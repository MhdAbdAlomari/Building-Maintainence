<?php

namespace App\Http\Controllers;

use App\Http\Resources\WalletTransactionResource;
use App\Models\AppSetting;
use App\Models\Wallet;
use App\Models\WithdrawalRequest;
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

        $totalDebt = $technician->getTotalDebt();
        $debtCeiling = AppSetting::getDebtCeiling();

        return $this->response([
            'id'               => $wallet->id,
            'technician_id'    => $wallet->technician_id,
            'balance'          => (int) $wallet->balance,
            'balance_label'    => number_format((int) $wallet->balance) . ' ' . $wallet->currency,
            'currency'         => $wallet->currency,
            'total_debt'       => $totalDebt,
            'total_debt_label' => number_format($totalDebt) . ' SYP',
            'is_blocked'       => $totalDebt >= $debtCeiling,
            'debt_ceiling'     => $debtCeiling,
        ]);
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
            'wallet' => [
                'id'            => $wallet->id,
                'technician_id' => $wallet->technician_id,
                'balance'       => (int) $wallet->balance,
                'balance_label' => number_format((int) $wallet->balance) . ' ' . $wallet->currency,
                'currency'      => $wallet->currency,
            ],
            'transactions' => WalletTransactionResource::collection($transactions),
            'pagination' => [
                'current_page' => $transactions->currentPage(),
                'last_page' => $transactions->lastPage(),
                'per_page' => $transactions->perPage(),
                'total' => $transactions->total(),
            ],
        ]);
    }

    public function transferInfo(HttpRequest $request)
    {
        $governorate = AppSetting::get('owner_governorate', 'damascus');
        $labels = WithdrawalRequest::governorateLabels();

        return $this->response([
            'owner_name'              => AppSetting::get('owner_name'),
            'owner_phone'             => AppSetting::get('owner_phone'),
            'owner_governorate'       => $governorate,
            'owner_governorate_label' => $labels[$governorate] ?? $governorate,
        ]);
    }
}
