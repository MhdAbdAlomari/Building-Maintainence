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
            'service_id'     => ['required', 'exists:services,id'],

            // نفس التحقق
            'address_id'     => [
                'required',
                Rule::exists('addresses', 'id')->where('user_id', $userId),
            ],

            'title'          => ['required', 'string', 'max:191'],
            'description'    => ['required', 'string'],
            'scheduled_date' => ['required', 'date', 'after_or_equal:today'],
            'scheduled_time' => ['required', 'date_format:H:i'],

            'region_id'      => ['prohibited'],
            'tenant_id'      => ['prohibited'],
            'technician_id'  => ['prohibited'],
            'status'         => ['prohibited'],
            'cancellation_reason' => ['prohibited'],
            'canceled_at'    => ['prohibited'],
        ];
    }
}
