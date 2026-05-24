<?php

namespace App\Http\Resources;

use App\Filament\Resources\UserResource;
use App\Http\Resources\UserResource as ResourcesUserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class RequestResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'service_id' => $this->service_id,
            'title' => $this->title,
            'description' => $this->description,

            'scheduled_date' => $this->scheduled_date
                ? Carbon::parse($this->scheduled_date)->format('Y-m-d')
                : null,

            'scheduled_time' => $this->scheduled_time
                ? Carbon::parse($this->scheduled_time)->format('H:i')
                : null,

            'estimated_price' => $this->estimated_price,
            'estimate_note' => $this->estimate_note,

            'final_approval_requested_at' => $this->final_approval_requested_at,

            'additions_approved' => (bool) $this->additions_approved,

            'can_add_additions' => $this->status === 'processing' && !$this->additions_approved,
            
            'final_price_syp' => $this->final_price_syp,
            'final_price_syp_label' => $this->final_price_syp
                ? number_format((int) $this->final_price_syp) . ' SYP'
                : null,
            'is_paid' => (bool) $this->is_paid,
            'paid_at' => $this->paid_at,
            'payment_method' => $this->whenLoaded('payments', function () {
                $paid = $this->payments->firstWhere('status', 'paid');
                return $paid?->payment_method;
            }),
            'can_pay' => $this->status === 'completed'
                && !empty($this->final_price_syp)
                && !$this->is_paid,
            'distance_km' => $this->when(
                array_key_exists('distance_km', $this->resource->getAttributes()),
                fn() => round((float) $this->distance_km, 1)
            ),
            'media' => MediaResource::collection($this->whenLoaded('media')),
            'address' => new AddressResource($this->whenLoaded('address')),
            'tenant'=>  new ResourcesUserResource($this->whenLoaded('tenant')),
        ];
    }
}