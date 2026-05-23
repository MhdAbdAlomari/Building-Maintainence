<?php

namespace App\Http\Controllers;

use App\Http\Resources\WalletResource;
use App\Http\Resources\WalletTransactionResource;
use App\Models\Wallet;
use Illuminate\Http\Request as HttpRequest;

class WalletController extends Controller
{
    public function balance(HttpRequest $request)
    {
        $technician = $request->user();

        $wallet = Wallet::firstOrCreate(
            ['technician_id' => $technician->id],
            ['balance' => 0, 'currency' => 'SYP']
        );

        return $this->response(new WalletResource($wallet));
    }

    public function transactions(HttpRequest $request)
    {
        $technician = $request->user();

        $wallet = Wallet::where('technician_id', $technician->id)->first();

        if (!$wallet) {
            return $this->response([
                'wallet' => null,
                'transactions' => [],
            ]);
        }

        $transactions = $wallet->transactions()
            ->latest()
            ->paginate(20);

        return $this->response([
            'wallet' => new WalletResource($wallet),
            'transactions' => WalletTransactionResource::collection($transactions),
            'pagination' => [
                'current_page' => $transactions->currentPage(),
                'last_page' => $transactions->lastPage(),
                'per_page' => $transactions->perPage(),
                'total' => $transactions->total(),
            ],
        ]);
    }
}
