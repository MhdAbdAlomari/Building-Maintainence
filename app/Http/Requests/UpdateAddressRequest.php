<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'region_id'    => ['sometimes', 'integer', 'exists:regions,id'],
            'label'        => ['sometimes', 'nullable', 'string', 'max:50'],
            'address_text' => ['sometimes', 'nullable', 'string', 'max:255'],
            'lat'          => ['sometimes', 'numeric', 'between:-90,90'],
            'lng'          => ['sometimes', 'numeric', 'between:-180,180'],
            'is_default'   => ['sometimes', 'boolean'],
        ];
    }
}
