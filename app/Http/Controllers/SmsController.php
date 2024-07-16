<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SmsController extends Controller
{
    use ResponseTrait;
    //sendOTP
    public function sendOTP(Request $request)
{
    

    try {
        $otp = rand(1000, 9999);
        $message = "Use this OTP to verify the $request->phone phone number you used to register in GURU NIWASA LMS.\nOTP: $otp (One Time Use)";
        //$sendOTP = sendSMS($request->phone, $message); // Call sendSMS method

        // Log SMS response for debugging or auditing purposes
        //Log::info("SMS sent to $request->phone: $sendOTP");

        // Return a successful JSON response with the OTP
        return $this->responseSuccess($otp, 'OTP sent successfully.', 200);
    } catch (Exception $exception) {
        // Handle any exceptions and return an error JSON response
        return $this->responseError([], $exception->getMessage(), 400);
    }
}
}