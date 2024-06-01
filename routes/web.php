<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayPalController;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/paypal/create-order', [PayPalController::class, 'createOrder']);
Route::post('/paypal/capture-order', [PayPalController::class, 'captureOrder']);
