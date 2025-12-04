<?php

namespace App\Modules\Stripe\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Exception;

class StripeController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:1'
            ]);

            Stripe::setApiKey(config('services.stripe.secret_key'));

            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount * 100,
                'currency' => 'usd',
                'automatic_payment_methods' => ['enabled' => true],
            ]);

            return apiResponse(
                true,
                "Payment intent created successfully",
                [
                    'clientSecret' => $paymentIntent->client_secret,
                    'publishableKey' => config('services.stripe.public_key'),
                ]
            );

        } catch (Exception $e) {
            return apiResponse(false, $e->getMessage(), null, 500);
        }
    }
}
