<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PayPalService;

class PayPalController extends Controller
{
    private $payPalService;

    public function __construct(PayPalService $payPalService)
    {
        $this->payPalService = $payPalService;
    }

    public function createOrder(Request $request)
    {
        $amount = $request->input('amount');
        $response = $this->payPalService->createOrder($amount);

        return response()->json($response);
    }

    public function captureOrder(Request $request)
    {
        $orderId = $request->input('orderId');
        $response = $this->payPalService->captureOrder($orderId);

        return response()->json($response);
    }
}
