<?php

namespace App\Http\Requests;

use App\Models\Commission;
use App\Models\DebtSettlement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDebtSettlementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role === 'technician';
    }

    public function rules(): array
    {
        $technician = $this->user();

        $totalDebt = (int) Commission::where('technician_id', $technician->id)
            ->where('status', 'pending_debt')
            ->sum('commission_amount');

        return [
            'amount'        => ['required', 'integer', 'min:1', "max:$totalDebt"],
            'branch'        => ['required', Rule::in(array_keys(DebtSettlement::branchLabels()))],
            'receipt_image' => ['required', 'image', 'max:5120'],
            'note'          => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.max' => 'The settlement amount exceeds your outstanding debt.',
        ];
    }
}
