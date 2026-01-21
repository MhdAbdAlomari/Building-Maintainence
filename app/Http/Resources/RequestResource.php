<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
{
    private function statusForMobile(?string $status): ?string
    {
        return match ($status) {
            'pending'    => 'pending',
            'accepted'   => 'accept',
            'on_the_way' => 'processing',
            'complete'   => 'done',
            'canceled'   => 'canceled',
            default      => $status,
        };
    }

    public function toArray($request)
    {
        return [
            'id'             => $this->id,

            // backend canonical (لا تغيّره)
            'status'         => $this->status,

            // mobile-friendly status
            'status_mobile'  => $this->statusForMobile($this->status),

            'service_id'     => $this->service_id,
           // 'address_id'     => $this->address_id,
            'region_id'      => $this->address?->region_id,

            'title'          => $this->title,
            'description'    => $this->description,
            'scheduled_date' => $this->scheduled_date,
            'scheduled_time' => $this->scheduled_time,

            // payment fields7
            'final_price_syp' => $this->final_price_syp,
            'final_price_syp_label' => number_format((int)$this->final_price_syp) . ' SYP',
            'is_paid'         => (bool) $this->is_paid,
            'paid_at'         => $this->paid_at,

            'can_pay' => $this->status === 'complete'
                && !empty($this->final_price_syp)
                && !$this->is_paid,
        ];
    }
}
