<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phonepe extends Model
{
    /* use HasFactory;  */

    public static function phonepe_info(){
    	if(env('PHONEPE_MODE') == 'sandbox'){
    		$details['url'] = "https://api-preprod.phonepe.com/apis/merchant-simulator/";
    		$details['merchantId'] = "MERCHANTUAT";
    		$details['salt_key'] = "099eb0cd-02cf-4e2a-8aca-3e6c6aff0399";
    		$details['salt_index'] = "1";
    	}else{
            $details['url'] = "https://api.phonepe.com/apis/hermes/";
            $details['merchantId'] = "M1LVLL5NV0H1";
            $details['salt_key'] = "ecc1a50f-51a6-4850-b893-b3c4d60820fd";
            $details['salt_index'] = "1";
    	}
    	return $details;
    }

    public static function getPaymentUrl($orderDetails){ 
    	$phonepe_details = Phonepe::phonepe_info();
    	$params['merchantId'] = $phonepe_details['merchantId'];
    	$params['merchantTransactionId'] = (string)$orderDetails['id'];
    	$params['merchantUserId'] = (string)$orderDetails['user_id'];
    	$params['amount'] = $orderDetails['grand_total']*100;
    	//$params['redirectUrl'] = "https://webhook.site/9da3d246-d9a7-4a64-b22e-9a0dd28ee3e3";
        $params['redirectUrl'] = url('phonepe/redirect');
    	$params['redirectMode'] = 'POST';
    	//$params['callbackUrl'] = "https://webhook.site/9da3d246-d9a7-4a64-b22e-9a0dd28ee3e3";
        $params['callbackUrl'] = url('phonepe/callback');
    	if(!empty($orderDetails['getuser']['mobile'])){
    	//	$params['mobileNumber'] = $orderDetails['getuser']['mobile'];
    	}
    	$params['paymentInstrument']['type'] = "PAY_PAGE"; 
    	$request_json = json_encode($params,JSON_UNESCAPED_SLASHES);
        $base64 = base64_encode($request_json);
        $sha = hash('sha256',$base64.'/pg/v1/pay'.$phonepe_details['salt_key']).'###'.$phonepe_details['salt_index'];
        $params =array();
        $params['X-VERIFY']  = $sha;
        $params['requestType']  = 'POST';
        $params['api_url']  = $phonepe_details['url'].'pg/v1/pay'; 
        $params['post_data']['request']  = $base64;  
    	$resp = Phonepe::phonepe_curl_request($params); 
        if(isset($resp['data']['data']['instrumentResponse']['redirectInfo']['url'])){
            $paymentUrl = $resp['data']['data']['instrumentResponse']['redirectInfo']['url'];
        }else{
            $paymentUrl = "";
        }
        return $paymentUrl;
    }

    public static function phonepe_curl_request($params){
    	$apiurl = $params['api_url'];
		$ch = curl_init($apiurl);
		if($params['requestType'] == 'POST'){
			$payload = json_encode($params['post_data']);
            //echo "<pre>"; print_r($payload); die;
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
			$headers = array('Content-Type:application/json','X-VERIFY:'.$params['X-VERIFY']);
		}else{
            if(isset($params['X-MERCHANT-ID'])){
                $headers = array('Content-Type:application/json','X-VERIFY:'.$params['X-VERIFY'],'X-MERCHANT-ID:'.$params['X-MERCHANT-ID']);
            }else{
                $headers = array('Content-Type:application/json');
            }
			curl_setopt($ch, CURLOPT_POST, 0);
		}
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
		# Return response instead of printing.
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		# Send request.
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
		    $response= array('status'=>false,'message'=>'Not able to complete request');
		}else{
		    // check the HTTP status code of the request
		    $resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		    if($resultStatus == 200) {
		        $response = array('status'=>true,'message'=>'ok','data'=>json_decode($result,true));
		    }else{
		        $response = array('status'=>false,'message'=>'Bad Request. Please try again');
		    }
		}
		curl_close($ch);
		return $response;
    }

    public static function checkOrderStatus($orderid){
        $phonepe_details = Phonepe::phonepe_info();
        $sha = hash('sha256','/pg/v1/status/'.$phonepe_details['merchantId'].'/'.$orderid.$phonepe_details['salt_key']).'###'.$phonepe_details['salt_index'];
        $params =array();
        $params['X-VERIFY']  = $sha;
        $params['X-MERCHANT-ID']  = $phonepe_details['merchantId'];
        $params['requestType']  = 'GET';
        $params['api_url']  = $phonepe_details['url'].'pg/v1/status/'.$phonepe_details['merchantId'].'/'.$orderid;
        $resp = Phonepe::phonepe_curl_request($params);
        return $resp;
    }
}
