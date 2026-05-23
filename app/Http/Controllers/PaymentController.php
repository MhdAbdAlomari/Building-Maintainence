<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\Request as WorkRequest;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    public function pay(HttpRequest $request, $id)
    {
        $tenant = $request->user();

        $item = WorkRequest::where('id', $id)
            ->where('tenant_id', $tenant->id)
            ->firstOrFail();

        if ($item->status !== 'completed') {
            return $this->response(null, 'Request not completed', 422);
        }

        if (empty($item->final_price_syp)) {
            return $this->response(null, 'Final price not set', 422);
        }

        if ($item->is_paid) {
            return $this->response(null, 'Already paid', 422);
        }

        $data = $request->validate([
            'payment_method' => ['sometimes', 'in:stripe,cash'],
        ]);

        $paymentMethod = $data['payment_method'] ?? 'stripe';

        if ($paymentMethod === 'cash') {
            return $this->handleCashPayment($item, $tenant);
        }

        return $this->handleStripePayment($item, $tenant);
    }

    private function handleCashPayment(WorkRequest $item, $tenant)
    {
        return DB::transaction(function () use ($item, $tenant) {
            $payment = Payment::create([
                'request_id' => $item->id,
                'tenant_id' => $tenant->id,
                'amount_usd_cents' => 0,
                'currency' => 'SYP',
                'payment_method' => 'cash',
                'status' => 'paid',
            ]);

            $item->update([
                'is_paid' => true,
                'paid_at' => now(),
            ]);

            $this->creditTechnicianWallet($item);

            return $this->response([
                'payment_id' => $payment->id,
                'payment_method' => 'cash',
                'amount_syp' => $item->final_price_syp,
                'message' => 'Cash payment recorded and technician wallet credited',
            ]);
        });
    }

    private function handleStripePayment(WorkRequest $item, $tenant)
    {
        $rate = (float) config('services.exchange.syp_per_usd', 15000);
        $usdCents = (int) round((($item->final_price_syp / $rate) * 100));
        $usdCents = max(50, $usdCents);

        $payment = Payment::create([
            'request_id' => $item->id,
            'tenant_id' => $tenant->id,
            'amount_usd_cents' => $usdCents,
            'currency' => config('services.stripe.currency', 'usd'),
            'payment_method' => 'stripe',
            'status' => 'pending',
        ]);

        $stripe = new StripeClient(config('services.stripe.secret'));

        $session = $stripe->checkout->sessions->create([
            'mode' => 'payment',
            'success_url' => config('app.url') . '/payment/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => config('app.url') . '/payment/cancel',

            'metadata' => [
                'payment_id' => (string) $payment->id,
                'request_id' => (string) $item->id,
            ],

            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => $payment->currency,
                    'unit_amount' => $payment->amount_usd_cents,
                    'product_data' => [
                        'name' => "Maintenance Request #{$item->id}",
                    ],
                ],
            ]],
        ]);

        $payment->update([
            'stripe_session_id' => $session->id,
        ]);

        return $this->response([
            'payment_url' => $session->url,
            'payment_method' => 'stripe',
            'amount_syp' => $item->final_price_syp,
            'amount_usd_cents' => $usdCents,
        ]);
    }

    public static function creditTechnicianWallet(WorkRequest $item): void
    {
        if (!$item->technician_id || !$item->final_price_syp) {
            return;
        }

        $wallet = Wallet::firstOrCreate(
            ['technician_id' => $item->technician_id],
            ['balance' => 0, 'currency' => 'SYP']
        );

        $wallet->increment('balance', $item->final_price_syp);

        WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'amount' => $item->final_price_syp,
            'type' => 'credit',
            'status' => 'completed',
            'request_id' => $item->id,
            'description' => "Payment for request #{$item->id}",
        ]);
    }
}
