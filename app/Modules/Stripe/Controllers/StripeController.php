<?php

namespace App\Modules\Stripe\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment;
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
                'amount' => 'required|numeric|min:1',
            ]);

            Stripe::setApiKey(config('services.stripe.secret_key'));

            // Create Stripe PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount * 100, // Stripe works with cents
                'currency' => 'usd',
                'automatic_payment_methods' => ['enabled' => true],
            ]);

            // Save payment in the database
            $payment = Payment::create([
                'price' => $request->amount,
                'status' => 'pending',
                'payment_details' => json_encode([
                    'payment_intent_id' => $paymentIntent->id,
                    'client_secret' => $paymentIntent->client_secret,
                ])
            ]);

            return apiResponse(
                true,
                'Payment intent created successfully',
                [
                    'clientSecret' => $paymentIntent->client_secret,
                    'publishableKey' => config('services.stripe.public_key'), //for flutter
                ]
            );

        } catch (Exception $e) {
            return apiResponse(false, $e->getMessage(), null, 500);
        }
    }
}
