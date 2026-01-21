<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'label'       => $this->label,
            'address_text'=> $this->address_text,
            'latitude'         => $this->latitude,
            'longitude'         => $this->longitude,
            'is_default'  => (bool) $this->is_default,

            'region' => $this->whenLoaded('region', function () {
                return [
                    'id'   => $this->region?->id,
                    'name' => $this->region?->name,
                ];
            }),

            'created_at' => $this->created_at,
        ];
    }
}
