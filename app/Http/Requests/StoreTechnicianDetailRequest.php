<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTechnicianDetailRequest extends FormRequest
{
    public function authorize(): bool
    {
        // نضمن أن اللي عم يستدعي هو أدمن
        return $this->user()?->role === 'admin';
    }

    public function rules(): array
    {
        return [
            // 1) بيانات الـ User الجديد (الفني)
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],

            'address'   => ['nullable', 'string', 'max:255'],
            'region_id' => ['nullable', 'exists:regions,id'],

            // 2) بيانات TechnicianDetail
            'service_id'          => ['required', 'exists:services,id'],
            'years_of_experience' => ['nullable', 'integer', 'min:0', 'max:60'],
            'skills_description'  => ['nullable', 'string', 'max:2000'],
        ];
    }
}
