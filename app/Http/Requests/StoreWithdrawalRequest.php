<?php

namespace App\Http\Requests;

use App\Models\WithdrawalRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWithdrawalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role === 'technician';
    }

    public function rules(): array
    {
        $technician = $this->user();
        $wallet = $technician?->wallet;

        $balance = (int) ($wallet->balance ?? 0);
        $pending = $wallet
            ? (int) WithdrawalRequest::where('wallet_id', $wallet->id)
                ->where('status', 'pending')
                ->sum('amount')
            : 0;

        $available = max(0, $balance - $pending);

        return [
            'amount'             => ['required', 'integer', 'min:1', "max:$available"],
            'branch'             => ['required', Rule::in(array_keys(WithdrawalRequest::branchLabels()))],
            'governorate'        => ['required', Rule::in(array_keys(WithdrawalRequest::governorateLabels()))],
            'receiver_full_name' => ['required', 'string', 'min:3', 'max:255'],
            'receiver_phone'     => ['required', 'string', 'max:50'],
            'note'               => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.max' => 'The withdrawal amount exceeds your available balance.',
        ];
    }
}
