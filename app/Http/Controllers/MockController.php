<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use SebastianBergmann\Type\GenericObjectType;

class MockController extends Controller
{
    const GOOGLE_API = 'https://mock.api.google.com/authorise_purchase';
    const APPLE_API = 'https://mock.api.apple.com/authorise_purchase';

    private string $endpoint;

    public function authorizePurchase($os, $receipt): Response
    {
        if($os == 'android') {
            $this->endpoint = self::GOOGLE_API;
            $username = $_ENV['GOOGLE_API_USERNAME'];
            $password = $_ENV['GOOGLE_API_PASSWORD'];
        }else{
            $this->endpoint = self::APPLE_API;
            $username = $_ENV['APPLE_API_USERNAME'];
            $password = $_ENV['APPLE_API_PASSWORD'];
        }

        $this->mockApi($receipt);

        return Http::withBasicAuth($username, $password)
        ->post($this->endpoint, [
            'receipt' => $receipt,
        ]);
    }

    private function mockApi($receipt): void
    {
        $expireDate = new DateTime(null, new DateTimeZone('America/Chicago')); // UTC-6 timezone
        $expireDate->modify('+1 month');

        Http::fake([
            $this->endpoint => Http::response([
                'status' => $this->validateReceipt($receipt),
                'expire-date' => $expireDate->format('Y-m-d H:i:s'),
            ], $this->generateStatus($receipt))
        ]);
    }

    private function validateReceipt($receipt): bool
    {
        $lastCharacter = intval(substr($receipt, -1));
        if($lastCharacter % 2 == 1){
            return true;
        }

        return false;
    }

    private function generateStatus($receipt): int
    {
        $status = $this->validateReceipt($receipt) ? 200 : 400;
        if(intval(substr($receipt, -2)) % 2 == 0){
            $status = 429;
        }
        return $status;
    }
}
