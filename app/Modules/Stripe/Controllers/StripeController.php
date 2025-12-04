<?php

namespace App\Modules\Stripe\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
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
                'appointment_id' => 'required|integer'
            ]);

            Stripe::setApiKey(config('services.stripe.secret_key'));

            // Create Stripe PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount * 100,
                'currency' => 'usd',
                'automatic_payment_methods' => ['enabled' => true],
            ]);

            // Save Payment
            $payment = Payment::create([
                'price' => $request->amount,
                'status' => 'pending',
                'stripe_payment_intent_id' => $paymentIntent->id,
                'payment_details' => [
                    'client_secret' => $paymentIntent->client_secret,
                ]
            ]);

            return apiResponse(
                true,
                'Payment intent created successfully',
                [
                    'payment_intent_id' => $paymentIntent->id,   // <── Added
                    'client_secret' => $paymentIntent->client_secret,
                    'payment_id' => $payment->id,
                    'publishableKey' => config('services.stripe.public_key'),
                ]
            );

        } catch (Exception $e) {
            return apiResponse(false, $e->getMessage(), null, 500);
        }
    }


    public function confirm(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required',
            'appointment_id' => 'required|exists:appointments,id'
        ]);

        Stripe::setApiKey(config('services.stripe.secret_key'));

        // Retrieve payment intent from Stripe
        $intent = PaymentIntent::retrieve($request->payment_intent_id);

        // Case: payment not finished
        if ($intent->status !== 'succeeded') {
            return apiResponse(false, 'Payment not completed', [
                'stripe_status' => $intent->status
            ], 400);
        }

        // Find payment in DB
        $payment = Payment::where('stripe_payment_intent_id', $intent->id)->first();

        if (!$payment) {
            return apiResponse(false, 'Payment record not found in database', null, 404);
        }

        // Update payment record
        $payment->update([
            'status' => 'paid',
        ]);

        // Update appointment record
        $appointment = Appointment::find($request->appointment_id);

        $appointment->update([
            'payment_id' => $payment->id,
            'status' => 'paid'
        ]);

        return apiResponse(true, 'Payment confirmed & appointment updated successfully');
    }

}
