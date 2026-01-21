<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Request as WorkRequest;
use Illuminate\Http\Request as HttpRequest;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    
    public function pay(HttpRequest $request, $id)
    {
        $tenant = $request->user();

        $item = WorkRequest::where('id', $id)
            ->where('tenant_id', $tenant->id)
            ->firstOrFail();

        if ($item->status !== 'complete') {
            return $this->response(null, 'Request not complete', 422);
        }
        if (empty($item->final_price_syp)) {
            return $this->response(null, 'Final price not set', 422);
        }
        if ($item->is_paid) {
            return $this->response(null, 'Already paid', 422);
        }
        
        $rate = (float) config('services.exchange.syp_per_usd', 15000);
        $usdCents = (int) round((($item->final_price_syp / $rate) * 100));
        $usdCents = max(50, $usdCents);

        $payment = Payment::create([
            'request_id' => $item->id,
            'tenant_id' => $tenant->id,
            'amount_usd_cents' => $usdCents,
            'currency' => config('services.stripe.currency', 'usd'),
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

        $payment->update(['stripe_session_id' => $session->id]);

        return $this->response([
            'payment_url' => $session->url,
            'amount_syp' => $item->final_price_syp,
            'amount_usd_cents' => $usdCents,
        ]);
        
    }
}
