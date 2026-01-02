<?php

namespace App\Modules\Stripe\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Appointment;
use App\Enums\AppointmentStatus;
use Illuminate\Http\Request;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Exception $e) {
            return response('Invalid payload', 400);
        }

        if ($event->type === 'payment_intent.succeeded') {
            $intent = $event->data->object;

            $payment = Payment::where('stripe_payment_intent_id', $intent->id)->first();

            if ($payment && $payment->status !== 'paid') {
                $payment->update(['status' => 'paid']);

                Appointment::where('id', $payment->appointment_id)->update([
                    'status' => AppointmentStatus::Paid->value,
                    'payment_id' => $payment->id,
                ]);
            }
        }

        return response('Webhook handled', 200);
    }
}
