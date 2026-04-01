<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestAdditionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price_syp' => $this->price_syp,
            'price_syp_label' => number_format((int) $this->price_syp) . ' SYP',
        ];
    }
}