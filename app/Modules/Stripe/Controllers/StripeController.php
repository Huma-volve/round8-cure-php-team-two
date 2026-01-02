<?php

namespace App\Modules\Stripe\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripeController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|integer|exists:appointments,id',
        ]);

        try {
            $user = $request->user();

            $appointment = Appointment::where('id', $request->appointment_id)
                ->where('user_id', $user->id)
                ->firstOrFail();

            Stripe::setApiKey(config('services.stripe.secret_key'));

            $amount = max(floatval($appointment->price), 0.5);

            $paymentIntent = PaymentIntent::create([
                'amount' => intval($amount * 100),
                'currency' => 'usd',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
                'metadata' => [
                    'appointment_id' => $appointment->id,
                    'user_id' => $user->id,
                ],
            ]);

            $payment = Payment::create([
                'price' => $appointment->price,
                'status' => 'pending',
                'user_id' => $user->id,
                'appointment_id' => $appointment->id,
                'stripe_payment_intent_id' => $paymentIntent->id,
            ]);

            return apiResponse(true, 'Payment intent created successfully', [
                'client_secret' => $paymentIntent->client_secret,
                'payment_id' => $payment->id,
                'publishableKey' => config('services.stripe.public_key'),
            ]);
        } catch (\Exception $e) {
            return apiResponse(false, $e->getMessage(), null, 500);
        }
    }
}
