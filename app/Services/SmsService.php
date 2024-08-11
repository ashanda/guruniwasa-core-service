<?php 
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected $configFile;
    protected $accessToken;

    public function __construct()
    {
        $this->configFile = storage_path('app/config.json'); // Path to store your configuration
        $this->accessToken = $this->getAccessToken();
    }

    public function login()
    {
        $postData = [
            'username' => env('BSMS_USERNAME'),
            'password' => env('BSMS_PASSWORD'),
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => '*/*',
            'X-API-VERSION' => 'v1',
        ])->post('https://bsms.hutch.lk/api/login', $postData);

        if ($response->failed()) {
            Log::error('Login failed: ' . $response->body());
            return null;
        }

        $responseData = $response->json();
        $this->saveAccessToken($responseData['accessToken']);

        return $responseData['accessToken'];
    }

    public function sendSMS($number, $message)
    {
        $this->ensureTokenIsValid();

        $mask = env('SMS_SENDER_ID');
        $campaignName = env('SMS_CAMPAIGN_NAME');
        $numbers = "94" . substr($number, 1);

        $postData = [
            'campaignName' => $campaignName,
            'mask' => $mask,
            'numbers' => $numbers,
            'content' => $message,
        ];
        
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => '*/*',
            'X-API-VERSION' => 'v1',
            'Authorization' => 'Bearer ' . $this->accessToken,
        ])->post('https://bsms.hutch.lk/api/sendsms', $postData);

        if ($response->failed()) {
            Log::error('SMS send failed: ' . $response->body());
        }

        return $response->json();
    }

    protected function getAccessToken()
    {
        if (file_exists($this->configFile)) {
            $configData = json_decode(file_get_contents($this->configFile), true);
            return $configData['accessToken'] ?? null;
        }
        return null;
    }

    protected function saveAccessToken($token)
    {
        file_put_contents($this->configFile, json_encode(['accessToken' => $token], JSON_PRETTY_PRINT));
        $this->accessToken = $token;
    }

    protected function ensureTokenIsValid()
    {
        // Here you can add additional checks to verify if the token is expired
        if (!$this->accessToken) {
            $this->login(); // Attempt to re-login if the token is not available
            $this->accessToken = $this->getAccessToken(); // Update the access token
        }
    }
}
