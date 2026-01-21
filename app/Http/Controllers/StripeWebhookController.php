<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request as HttpRequest;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(HttpRequest $request)
    {
        $payload = $request->getContent();
        $sig = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sig, $secret);
        } catch (\Throwable $e) {
            return response('Invalid', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $paymentId = $session->metadata->payment_id ?? null;
            if (!$paymentId) {
                return response('OK', 200);
            }

            $payment = Payment::find($paymentId);
            if (!$payment) {
                return response('OK', 200);
            }

            if ($payment->status !== 'paid') {
                $payment->update([
                    'status' => 'paid',
                    'stripe_payment_intent_id' => $session->payment_intent ?? null,
                ]);

               $payment->workRequest()->update([
                'is_paid' => true,
                'paid_at' => now(),
            ]);

            }
        }

        return response('OK', 200);
    }
}


