<?php
namespace App\Services;
use App\Order;
use GuzzleHttp\Client;
class DelhiveryService
{
	public function createOrder($orderID)
	{   
		$orderDetails = Order::with(['order_address','getuser','order_products','histories'])->where('id',$orderID)->first();
		$orderDetails = json_decode(json_encode($orderDetails),true); 
		
		if(!empty($orderDetails)){ 
			
			$order_products = $orderDetails['order_products'];
			$order_address = $orderDetails['order_address']; 
			$productNames ='';
			
			foreach($order_products as $order_product){
				if($productNames == ''){
					$productNames = ucfirst(strtolower($order_product['product_name']));
				}else{
					$productNames .= ','.ucfirst(strtolower($order_product['product_name']));
				}
			}
			
			if($orderDetails['payment_method'] == 'cod'){
				$payment_mode = 'COD';
				$cod_amount = (int)$orderDetails['grand_total'];
			}else{
				$payment_mode = 'Prepaid';
				$cod_amount = 0;
			}
			
			$user = $orderDetails['getuser'];
			
			if(!empty($orderDetails['weight'])){
				$weight = $orderDetails['weight'];
			}else{
				$weight = "";
			}
			
			
			$orderData = [
				"shipments" => [
							[
							"waybill" => "", /* leave blank to auto-generate */
							"order" => (int)$orderDetails['id'],
							"products_desc" => $productNames,
							"cod_amount" => $cod_amount,
							"total_amount" => $orderDetails['grand_total'],
							"name" => $order_address['shipping_name'],
							"add" => $order_address['shipping_address'],
							"city" => $order_address['shipping_city'],
							"state" => $order_address['shipping_state'],
							"country" => "India",
							"phone" => $order_address['shipping_mobile'], 
							"pin" => $order_address['shipping_postcode'], 
							"payment_mode" => $payment_mode,
							"return_address" => "",
							"return_pin" => "",
							"return_city" => "",
							"return_state" => "",
							"return_phone" => "",
							"weight" => $weight,
							"seller_gst_tin" => "",
							"seller_name" => "",
							"seller_address" => "",
							"seller_city" => "",
							"seller_state" => "",
							"seller_pin" => ""
							]
				],
				"pickup_location" => [
							"name" => "RAGE KNIT SURFACE"
				]
			];
			$payload = $orderData;  
			$client = new Client();
			$response = $client->post(env('DELHIVERY_CREATE_ORDER_URL'), [
				'headers' => [
					'Authorization' => 'Token ' . env('DELHIVERY_API_KEY'),
				],
				'form_params' => [
					'format' => 'json',
					'data' => json_encode($payload)
				]
			]);
			return json_decode($response->getBody(), true);
		}
	}
	public function trackOrder($waybill)
	{
		$client = new \GuzzleHttp\Client();

		$response = $client->get('https://track.delhivery.com/api/v1/packages/json/', [
			'headers' => [
				'Authorization' => 'Token ' . env('DELHIVERY_API_KEY'),
			],
			'query' => [
				'waybill' => $waybill
			]
		]);

		return json_decode($response->getBody(), true);
	}
}