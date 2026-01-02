<?php

use App\Modules\Stripe\Controllers\StripeController;
use App\Modules\Stripe\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;

Route::prefix('stripe')->middleware('auth:sanctum')->group(function () {
    Route::post('/create-payment-intent', [StripeController::class, 'createPaymentIntent']);
});

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);
