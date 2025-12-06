<?php

namespace App\Modules\Stripe\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Exception;
use App\Enums\AppointmentStatus;

class StripeController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:1',
                'appointment_id' => 'required|integer|exists:appointments,id'
            ]);

            $user = $request->user();

            $appointment = Appointment::where('id', $request->appointment_id)->where('user_id', $user->id)->firstOrFail();

            Stripe::setApiKey(config('services.stripe.secret_key'));

            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount * 100,
                'currency' => 'usd',
                'automatic_payment_methods' => ['enabled' => true],
            ]);

            $payment = Payment::create([
                'price' => $request->amount,
                'status' => 'pending',
                'user_id' => $user->id,
                'appointment_id' => $appointment->id,
                'stripe_payment_intent_id' => $paymentIntent->id,
                'payment_details' => json_encode([
                    'client_secret' => $paymentIntent->client_secret,
                ]),
            ]);

            return apiResponse(
                true,
                'Payment intent created successfully',
                [
                    'payment_intent_id' => $paymentIntent->id,
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
            'appointment_id' => 'required|integer|exists:appointments,id'
        ]);

        try {
            $user = $request->user();

            $appointment = Appointment::where('id', $request->appointment_id)
                ->where('user_id', $user->id)
                ->firstOrFail();

            Stripe::setApiKey(config('services.stripe.secret_key'));

            $intent = PaymentIntent::retrieve($request->payment_intent_id);

            if ($intent->status !== 'succeeded') {
                return apiResponse(false, 'Payment not completed', [
                    'stripe_status' => $intent->status
                ], 400);
            }

            $payment = Payment::where('stripe_payment_intent_id', $intent->id)
                ->where('user_id', $user->id)
                ->firstOrFail();

            // Update payment
            $payment->update([
                'status' => 'paid',
            ]);

            // Update appointment with enum value
            $appointment->update([
                'payment_id' => $payment->id,
                'status' => AppointmentStatus::Paid->value,
            ]);

            return apiResponse(true, 'Payment confirmed & appointment updated successfully');
        } catch (Exception $e) {
            return apiResponse(false, $e->getMessage(), null, 500);
        }
    }
}
