<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletTransactionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'amount_label' => number_format((int) $this->amount) . ' SYP',
            'type' => $this->type,
            'status' => $this->status,
            'request_id' => $this->request_id,
            'description' => $this->description,
            'created_at' => $this->created_at,
        ];
    }
}
