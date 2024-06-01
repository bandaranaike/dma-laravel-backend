<?php

namespace App\Services;

use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPal\Core\PayPalHttpClient;
use PayPal\Core\SandboxEnvironment;
use PayPal\Core\ProductionEnvironment;

class PayPalService
{
    private $client;

    public function __construct()
    {
        $clientId = config('paypal.client_id');
        $clientSecret = config('paypal.client_secret');
        $environment = config('paypal.mode') === 'sandbox'
            ? new SandboxEnvironment($clientId, $clientSecret)
            : new ProductionEnvironment($clientId, $clientSecret);

        $this->client = new PayPalHttpClient($environment);
    }

    public function createOrder($amount)
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $amount
                    ]
                ]
            ]
        ];

        try {
            $response = $this->client->execute($request);
            return $response;
        } catch (HttpException $ex) {
            // Handle exception
        }
    }

    public function captureOrder($orderId)
    {
        $request = new OrdersCaptureRequest($orderId);

        try {
            $response = $this->client->execute($request);
            return $response;
        } catch (HttpException $ex) {
            // Handle exception
        }
    }
}
