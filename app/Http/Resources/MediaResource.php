<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         
            return [
            'id'         => $this->id,
            'type'       => $this->type,      // before/after
            'url'        => $this->url,       // /storage/requests/...
            'created_at' => $this->created_at,
        ];
    }
}
