<?php
namespace App\services\sms;

use GuzzleHttp\Client;
use Exception;

/* START: SmsApiDriver — implementation for smsapi.neilian.dev */
class SmsApiDriver implements SmsDriverInterface
{
    private string $apiUrl;
    private string $apiKey;
    private string $uid;

    /* START: __construct — loads SMS provider API credentials */
    public function __construct()
    {
        $this->apiUrl = $_ENV['SMS_API_URL'] ?? 'https://smsapi.neilian.dev/send';
        $this->apiKey = $_ENV['SMS_API_KEY'] ?? '';
        $this->uid    = $_ENV['SMS_API_UID'] ?? '';
    }
    /* END: __construct */

    /* START: send — transmits message via Guzzle client */
    public function send(string $phone, string $message): bool
    {
        if (empty($this->apiKey) || empty($this->uid)) {
            error_log('SmsApiDriver: Missing API key or UID');
            return false;
        }

        // Limit to standard single SMS length of 160 characters
        if (mb_strlen($message) > 160) {
            $message = mb_substr($message, 0, 160);
        }

        $client = new Client();

        try {
            $response = $client->post($this->apiUrl, [
                'headers' => [
                    'x-api-key'    => $this->apiKey,
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'uid'     => $this->uid,
                    'phone'   => $phone,
                    'message' => $message
                ],
                'http_errors' => false,
                'timeout'     => 10
            ]);

            $statusCode = $response->getStatusCode();
            return $statusCode >= 200 && $statusCode < 300;
        } catch (Exception $e) {
            error_log('SmsApiDriver send error: ' . $e->getMessage());
            return false;
        }
    }
    /* END: send */
}
/* END: SmsApiDriver */
