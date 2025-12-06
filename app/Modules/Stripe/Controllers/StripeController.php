<?php

namespace App\Modules\Stripe\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Enums\AppointmentStatus;

class StripeController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|integer|exists:appointments,id',
        ]);

        try {
            $user = $request->user();

            $appointment = Appointment::where('id', $request->appointment_id)->where('user_id', $user->id)->firstOrFail();

            Stripe::setApiKey(config('services.stripe.secret_key'));

            // تأكد أن المبلغ أكبر من الحد الأدنى المسموح
            $amount = max(floatval($appointment->price), 50); // 0.5 USD * 100 cents

            $paymentIntent = PaymentIntent::create([
                'amount' => intval($amount * 100), // تحويل الدولار إلى سنت
                'currency' => 'usd',
                'automatic_payment_methods' => ['enabled' => true], // Stripe يدير وسائل الدفع تلقائيًا
            ]);

            $payment = Payment::create([
                'price' => $appointment->price,
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

        } catch (\Exception $e) {
            return apiResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
            'appointment_id' => 'required|integer|exists:appointments,id',
        ]);

        try {
            $user = $request->user();

            $appointment = Appointment::where('id', $request->appointment_id)->where('user_id', $user->id)->firstOrFail();

            Stripe::setApiKey(config('services.stripe.secret_key'));

            $intent = PaymentIntent::retrieve($request->payment_intent_id);

            if ($intent->status !== 'succeeded') {
                return apiResponse(
                    false,
                    'Payment not completed',
                    ['stripe_status' => $intent->status],
                    400
                );
            }

            $payment = Payment::where('stripe_payment_intent_id', $intent->id)->where('user_id', $user->id)->firstOrFail();

            // تحديث حالة الدفع
            $payment->update(['status' => 'paid']);

            // تحديث حالة الموعد
            $appointment->update([
                'status' => AppointmentStatus::Paid->value,
                'payment_id' => $payment->id, // ربط الموعد بالدفع
            ]);

            return apiResponse(true, 'Payment confirmed & appointment updated successfully');

        } catch (\Exception $e) {
            return apiResponse(false, $e->getMessage(), null, 500);
        }
    }
}
