<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'technician_id' => $this->technician_id,
            'balance' => $this->balance,
            'balance_label' => number_format((int) $this->balance) . ' ' . $this->currency,
            'currency' => $this->currency,
            'updated_at' => $this->updated_at,
        ];
    }
}
