<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'name'        => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'min_price' =>['nullable','integer']
        ];
    }
}
