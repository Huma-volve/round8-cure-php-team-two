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
    // إنشاء PaymentIntent
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

            $amount = max((float)$appointment->price, 0.5);

            $paymentIntent = PaymentIntent::create([
                'amount' => (int)($amount * 100),
                'currency' => 'usd',
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never', // يمنع أي redirect
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

            return response()->json([
                'success' => true,
                'client_secret' => $paymentIntent->client_secret,
                'payment_id' => $payment->id,
                'publishableKey' => config('services.stripe.public_key'),
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // تأكيد الدفع
    public function confirmPayment(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|string',
            'appointment_id' => 'required|integer|exists:appointments,id',
        ]);

        $user = $request->user();
        $appointment = Appointment::where('id', $request->appointment_id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $payment = Payment::where('appointment_id', $appointment->id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        try {
            Stripe::setApiKey(config('services.stripe.secret_key'));

            // تأكيد الـ PaymentIntent
            $intent = PaymentIntent::retrieve($payment->stripe_payment_intent_id);
            $intent->confirm(['payment_method' => $request->payment_method_id]);

            $status = $intent->status;

            if ($status === 'succeeded') {
                $payment->update(['status' => 'paid']);
                $appointment->update(['status' => 'paid']);
            }

            return response()->json([
                'success' => $status === 'succeeded',
                'stripe_status' => $status
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
