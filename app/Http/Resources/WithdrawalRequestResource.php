<?php

namespace App\Http\Resources;

use App\Models\WithdrawalRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawalRequestResource extends JsonResource
{
    public function toArray($request): array
    {
        $branches     = WithdrawalRequest::branchLabels();
        $governorates = WithdrawalRequest::governorateLabels();

        return [
            'id'                 => $this->id,
            'amount'             => (int) $this->amount,
            'amount_label'       => number_format((int) $this->amount) . ' SYP',
            'branch'             => $this->branch,
            'branch_label'       => $branches[$this->branch] ?? $this->branch,
            'governorate'        => $this->governorate,
            'governorate_label'  => $governorates[$this->governorate] ?? $this->governorate,
            'receiver_full_name' => $this->receiver_full_name,
            'receiver_phone'     => $this->receiver_phone,
            'note'               => $this->note,
            'status'             => $this->status,
            'rejection_reason'   => $this->rejection_reason,
            'reviewed_at'        => $this->reviewed_at,
            'created_at'         => $this->created_at,
        ];
    }
}
