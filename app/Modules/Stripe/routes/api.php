<?php

use App\Modules\Stripe\Controllers\StripeController;

Route::post('/create-payment-intent', [StripeController::class, 'createPaymentIntent']);
Route::post('/confirm-payment', [StripeController::class, 'confirm']);
