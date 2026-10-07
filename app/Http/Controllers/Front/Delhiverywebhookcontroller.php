<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DelhiveryWebhookController extends Controller
{
    /**
     * POST /delhivery/webhook?token=YOUR_SECRET
     * Delhivery pushes a scan update here every time a shipment status changes.
     */
    public function handle(Request $request)
    {
        // 1. Shared secret check (put DELHIVERY_WEBHOOK_TOKEN in .env, add it to the URL you give Delhivery)
        $secret = env('DELHIVERY_WEBHOOK_TOKEN');
        if (empty($secret) || !hash_equals($secret, (string) $request->query('token'))) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }

        $payload = $request->all();
        Log::channel('single')->info('Delhivery webhook: ' . json_encode($payload));

        try {
            // Delhivery format: { "Shipment": { "AWB": "...", "ReferenceNo": "...", "Status": { "Status": "...", "StatusType": "DL", ... } } }
            $shipment   = $payload['Shipment'] ?? [];
            $waybill    = $shipment['AWB'] ?? null;
            $statusText = $shipment['Status']['Status'] ?? '';
            $statusType = strtoupper($shipment['Status']['StatusType'] ?? '');

            if (empty($waybill)) {
                return response()->json(['status' => true, 'message' => 'No waybill, ignored']);
            }

            $order = Order::where('waybill', $waybill)->first();
            if (!$order) {
                return response()->json(['status' => true, 'message' => 'Order not found, ignored']);
            }

            $newStatus = $this->mapStatus($statusType, $statusText);

            if ($newStatus && $order->order_status !== $newStatus) {
                // Never move a finished order backwards
                if (!in_array($order->order_status, ['Delivered', 'Cancelled'])) {
                    $order->order_status = $newStatus;
                    $order->save();

                    // Optional: add a row to your order history table here if you keep one
                    // e.g. $order->histories()->create(['order_status' => $newStatus, 'comment' => $statusText]);
                }
            }
        } catch (\Throwable $e) {
            Log::error('Delhivery webhook failed: ' . $e->getMessage());
        }

        // Always answer 200 so Delhivery does not keep retrying
        return response()->json(['status' => true]);
    }

    /**
     * Delhivery StatusType -> your order_status values.
     * Edit the right-hand side to match the statuses your admin panel uses.
     */
    private function mapStatus($type, $text)
    {
        $text = strtolower(trim($text));

        switch ($type) {
            case 'UD': // forward shipment
                if ($text === 'dispatched') { return 'Out For Delivery'; }
                if ($text === 'in transit' || $text === 'pending') { return 'Shipped'; }
                return null; // Manifested / Not Picked: leave status unchanged
            case 'DL':
                if ($text === 'delivered') { return 'Delivered'; }
                if ($text === 'rto') { return 'Returned'; }   // returned to origin, NOT delivered
                return null;                                  // DTO = reverse pickup, ignore
            case 'RT': // return journey back to you
                return 'Returned';
            case 'CN':
                return null; // reverse pickup cancelled, order unaffected
            default:       // PP / PU = reverse pickup scans, ignore
                return null;
        }
    }
}