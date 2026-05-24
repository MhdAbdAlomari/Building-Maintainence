<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\Commission;
use App\Models\Payment;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
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
                DB::transaction(function () use ($payment, $session) {
                    $payment->update([
                        'status' => 'paid',
                        'stripe_payment_intent_id' => $session->payment_intent ?? null,
                    ]);

                    $workRequest = $payment->workRequest;
                    $workRequest->update([
                        'is_paid' => true,
                        'paid_at' => now(),
                    ]);

                    if (!$workRequest->technician_id || !$workRequest->final_price_syp) {
                        return;
                    }

                    $finalPrice = (int) $workRequest->final_price_syp;
                    $commissionRate = AppSetting::getCommissionRate();
                    $commissionAmount = (int) ceil($finalPrice * $commissionRate / 100);

                    Commission::create([
                        'request_id'        => $workRequest->id,
                        'technician_id'     => $workRequest->technician_id,
                        'payment_id'        => $payment->id,
                        'request_amount'    => $finalPrice,
                        'commission_rate'   => $commissionRate,
                        'commission_amount' => $commissionAmount,
                        'payment_method'    => 'stripe',
                        'status'            => 'collected',
                        'collected_at'      => now(),
                    ]);

                    $existingDebt = (int) Commission::where('technician_id', $workRequest->technician_id)
                        ->where('status', 'pending_debt')
                        ->sum('commission_amount');

                    $deductions = $commissionAmount + $existingDebt;
                    $walletCredit = max(0, $finalPrice - $deductions);

                    if ($walletCredit > 0) {
                        PaymentController::creditTechnicianWallet($workRequest, $walletCredit);
                    }

                    if ($existingDebt > 0) {
                        Commission::where('technician_id', $workRequest->technician_id)
                            ->where('status', 'pending_debt')
                            ->update([
                                'status'       => 'collected',
                                'collected_at' => now(),
                            ]);
                    }
                });
            }
        }

        return response('OK', 200);
    }
}
