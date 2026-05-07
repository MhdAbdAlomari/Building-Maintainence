<?php

namespace App\Http\Resources;

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
            
            'final_price_syp' => $this->final_price_syp,
            'final_price_syp_label' => $this->final_price_syp
                ? number_format((int) $this->final_price_syp) . ' SYP'
                : null,
            'is_paid' => (bool) $this->is_paid,
            'paid_at' => $this->paid_at,
            'can_pay' => $this->status === 'completed'
                && !empty($this->final_price_syp)
                && !$this->is_paid,
            'media' => MediaResource::collection($this->whenLoaded('media')),
        ];
    }
}