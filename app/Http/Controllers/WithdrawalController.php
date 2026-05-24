<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWithdrawalRequest;
use App\Http\Resources\WithdrawalRequestResource;
use App\Models\Wallet;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request as HttpRequest;

class WithdrawalController extends Controller
{
    public function store(StoreWithdrawalRequest $request)
    {
        $technician = $request->user();

        $wallet = Wallet::firstOrCreate(
            ['technician_id' => $technician->id],
            ['balance' => 0, 'currency' => 'SYP']
        );

        $hasPending = WithdrawalRequest::where('technician_id', $technician->id)
            ->where('status', 'pending')
            ->exists();

        if ($hasPending) {
            return response()->json([
                'status'  => false,
                'message' => 'You already have a pending withdrawal request.',
                'data'    => null,
            ], 422);
        }

        $withdrawal = WithdrawalRequest::create([
            'technician_id'      => $technician->id,
            'wallet_id'          => $wallet->id,
            'amount'             => (int) $request->input('amount'),
            'branch'             => $request->input('branch'),
            'governorate'        => $request->input('governorate'),
            'receiver_full_name' => $request->input('receiver_full_name'),
            'receiver_phone'     => $request->input('receiver_phone'),
            'note'               => $request->input('note'),
            'status'             => 'pending',
        ]);

        return $this->response(
            new WithdrawalRequestResource($withdrawal),
            'Withdrawal request submitted successfully',
            201
        );
    }

    public function index(HttpRequest $request)
    {
        $technician = $request->user();

        $wallet = Wallet::firstOrCreate(
            ['technician_id' => $technician->id],
            ['balance' => 0, 'currency' => 'SYP']
        );

        $balance = (int) $wallet->balance;
        $pending = (int) WithdrawalRequest::where('wallet_id', $wallet->id)
            ->where('status', 'pending')
            ->sum('amount');
        $available = max(0, $balance - $pending);

        $withdrawals = WithdrawalRequest::where('technician_id', $technician->id)
            ->latest()
            ->paginate(20);

        return $this->response([
            'wallet_balance'    => $balance,
            'pending_amount'    => $pending,
            'available_balance' => $available,
            'currency'          => $wallet->currency,
            'withdrawals'       => WithdrawalRequestResource::collection($withdrawals),
            'pagination'        => [
                'current_page' => $withdrawals->currentPage(),
                'last_page'    => $withdrawals->lastPage(),
                'per_page'     => $withdrawals->perPage(),
                'total'        => $withdrawals->total(),
            ],
        ]);
    }

    public function destroy(HttpRequest $request, int $id)
    {
        $technician = $request->user();

        $withdrawal = WithdrawalRequest::where('id', $id)
            ->where('technician_id', $technician->id)
            ->first();

        if (!$withdrawal) {
            return response()->json([
                'status'  => false,
                'message' => 'Withdrawal request not found.',
                'data'    => null,
            ], 404);
        }

        if ($withdrawal->status !== 'pending') {
            return response()->json([
                'status'  => false,
                'message' => 'Only pending withdrawal requests can be cancelled.',
                'data'    => null,
            ], 422);
        }

        $withdrawal->delete();

        return $this->response(null, 'Withdrawal request cancelled successfully');
    }
}
