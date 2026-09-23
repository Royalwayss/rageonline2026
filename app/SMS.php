<?php

namespace App;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SMS
{
    /**
     * Send an SMS via the Stevia Digital SMS API.
     *
     * @param  string  $mobile    10-digit mobile number, no country code (91 prefix is added below)
     * @param  string  $message   Plain text message
     * @return array   ['status' => bool, 'response' => string]
     */
    public static function send($mobile, $message)
    {
        $authKey = env('STEVIA_SMS_AUTH_KEY');
        $senderId = env('STEVIA_SMS_SENDER_ID');

        if (empty($authKey) || empty($senderId)) {
            Log::error('Stevia SMS: STEVIA_SMS_AUTH_KEY or STEVIA_SMS_SENDER_ID not set in .env');
            return ['status' => false, 'response' => 'SMS gateway not configured.'];
        }

        // Normalise to 91XXXXXXXXXX if a bare 10-digit number was passed in
        $msisdn = preg_replace('/[^0-9]/', '', $mobile);
        if (strlen($msisdn) == 10) {
            $msisdn = '91'.$msisdn;
        }

        try {
            $response = Http::timeout(15)->get('https://sms.steviadigital.com/API/sms-api.php', [
                'auth'     => $authKey,
                'msisdn'   => $msisdn,
                'senderid' => $senderId,
                'message'  => $message,
            ]);

            return [
                'status'   => $response->successful(),
                'response' => $response->body(),
            ];
        } catch (\Exception $e) {
            Log::error('Stevia SMS send failed: '.$e->getMessage());
            return ['status' => false, 'response' => $e->getMessage()];
        }
    }
}
