<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardTechnicianResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'pending'=>$this->user?->pending,
            'estimate_price'=>$this->estimate_price,
        // 'confirmed'=>$confirmed,
        // 'processing'=>$processing,
        // 'awaiting_final_approval'=>$awaiting_final_approval,
        // 'completed'=>$completed,
        // 'rejected'=>$rejected,
        // 'cancelled'=>$cancelled
        ];
    }
}
