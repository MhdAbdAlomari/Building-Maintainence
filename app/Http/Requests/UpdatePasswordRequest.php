<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'current_password'      => ['required', 'string'],
            'new_password'          => ['required', 'string', 'min:6', 'confirmed'],
            // لازم يجي كمان حقل: new_password_confirmation
        ];
    }
}
