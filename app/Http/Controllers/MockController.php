<?php

namespace App\Http\Controllers;

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
        }else{
            $this->endpoint = self::APPLE_API;
        }

        $this->mockApi($receipt);

        return Http::post($this->endpoint, [
            'receipt' => $receipt,
        ]);
    }

    private function mockApi($receipt): void
    {
        $validation = $this->validateReceipt($receipt);

        date_default_timezone_set('America/Chicago'); // UTC-6 timezone

        Http::fake([
            $this->endpoint => Http::response([
                'status' => $validation,
                'expire-date' => date('Y-m-d H:i:s', strtotime('+1 month')),
            ], $validation ? 200 : 400)
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
}
