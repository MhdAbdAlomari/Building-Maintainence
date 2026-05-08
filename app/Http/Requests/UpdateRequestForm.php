<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequestForm extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user()?->id;

        return [
            'service_id' => ['required', 'exists:services,id'],

            'address_id' => [
                'required',
                Rule::exists('addresses', 'id')->where('user_id', $userId),
            ],

            'title' => ['required', 'string', 'max:191'],
            'description' => ['required', 'string'],
            'scheduled_date' => ['required', 'date', 'after_or_equal:today'],
            'scheduled_time' => ['required', 'date_format:H:i'],
            'images' => ['nullable', 'array', 'max:3'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],

            'additions_approved' => ['prohibited'],
            'tenant_id' => ['prohibited'],
            'technician_id' => ['prohibited'],
            'status' => ['prohibited'],
            'estimated_price' => ['prohibited'],
            'estimate_note' => ['prohibited'],
            'final_price_syp' => ['prohibited'],
            'is_paid' => ['prohibited'],
            'paid_at' => ['prohibited'],
            'cancellation_reason' => ['prohibited'],
            'cancelled_at' => ['prohibited'],
            'estimated_at' => ['prohibited'],
            'confirmed_at' => ['prohibited'],
            'processing_at' => ['prohibited'],
            'final_approval_requested_at' => ['prohibited'],
            'completed_at' => ['prohibited'],
            'rejected_at' => ['prohibited'],
        ];
    }
}
