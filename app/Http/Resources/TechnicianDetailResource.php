<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TechnicianDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
    'id' => $this->id,
    'user_id' => $this->user_id,
    'service_id' => $this->service_id,
    'years_of_experience' => $this->years_of_experience,
    'skills_description' => $this->skills_description,

    'user' => [
        'name' => $this->user?->name,
        'email' => $this->user?->email,
        'phone' => $this->user?->phone,
        'address' => $this->user?->address,
    ],
];
    }
}
