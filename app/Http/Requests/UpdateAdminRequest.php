<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'status' => [
                'sometimes',
                'required',
                'string',
                'in:pending,estimate_price,confirmed,processing,awaiting_final_approval,completed,rejected,cancelled'
            ],
            'technician_id' => [
                'sometimes',
                'nullable',
                'integer',
                'exists:users,id'
            ],
        ];
    }
}