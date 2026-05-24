<?php

namespace App\Http\Resources;

use App\Models\DebtSettlement;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DebtSettlementResource extends JsonResource
{
    public function toArray($request): array
    {
        $branches = DebtSettlement::branchLabels();

        return [
            'id'                  => $this->id,
            'amount'              => (int) $this->amount,
            'amount_label'        => number_format((int) $this->amount) . ' SYP',
            'branch'              => $this->branch,
            'branch_label'        => $branches[$this->branch] ?? $this->branch,
            'receipt_image'       => $this->receipt_image,
            'receipt_image_url'   => $this->receipt_image ? Storage::url($this->receipt_image) : null,
            'note'                => $this->note,
            'status'              => $this->status,
            'rejection_reason'    => $this->rejection_reason,
            'reviewed_at'         => $this->reviewed_at,
            'created_at'          => $this->created_at,
        ];
    }
}
