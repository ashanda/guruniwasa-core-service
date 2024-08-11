<?php

use Illuminate\Support\Facades\Log;

function sendSMS($number, $message){

    $sms_api_token=env("SMS_API_TOKEN");
    $sms_sender_id= env("SMS_SENDER_ID");
	$number = "+94".substr($number, 1);
	//$message=urlencode($message); // url encode your message

	$AUTH = $sms_api_token;  //Replace your Access Token
	$msgdata = array("recipient"=>$number, "sender_id"=>$sms_sender_id, "message"=>$message);


			
			$curl = curl_init();
			
			//IF you are running in locally and if you don't have https/SSL. then uncomment bellow two lines
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://sms.send.lk/api/v3/sms/send",
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_POSTFIELDS => json_encode($msgdata),
			  CURLOPT_HTTPHEADER => array(
				"accept: application/json",
				"authorization: Bearer $AUTH",
				"cache-control: no-cache",
				"content-type: application/x-www-form-urlencoded",
			  ),
			));

			$response = curl_exec($curl);
			Log::info($response);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			 // echo "cURL Error #:" . $err;
			} else {
			 // echo $response;
			}

			return $response;
}