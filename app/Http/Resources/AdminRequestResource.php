<?php

namespace App\Http\Resources;

use App\Http\Resources\RequestResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminRequestResource extends JsonResource
{
    public function toArray($request): array
    {
        // أساس الرد نفس RequestResource العادي
        $base = (new RequestResource($this))->toArray($request);

        return array_merge($base, [
            'tenant' => $this->whenLoaded('tenant', function () {
                return [
                    'id'    => $this->tenant->id,
                    'name'  => $this->tenant->name,
                    'email' => $this->tenant->email,
                    'phone' => $this->tenant->phone ?? null,
                ];
            }),

            'technician' => $this->whenLoaded('technician', function () {
                return [
                    'id'    => $this->technician->id,
                    'name'  => $this->technician->name,
                    'email' => $this->technician->email,
                ];
            }),

            'service' => $this->whenLoaded('service', function () {
                return [
                    'id'   => $this->service->id,
                    'name' => $this->service->name,
                ];
            }),

            'region' => $this->whenLoaded('region', function () {
                return [
                    'id'   => $this->region->id,
                    'name' => $this->region->name,
                ];
            }),

            'media_count' => $this->whenLoaded('media', function () {
                return $this->media->count();
            }),
        ]);
    }
}
