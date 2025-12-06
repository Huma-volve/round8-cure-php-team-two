<?php

use App\Modules\Stripe\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

Route::prefix('stripe')->middleware('auth:sanctum')->group(function () {
    Route::post('/create-payment-intent', [StripeController::class, 'createPaymentIntent']);
    Route::post('/confirm-payment', [StripeController::class, 'confirm']);
});
