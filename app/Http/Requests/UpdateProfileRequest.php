<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;//تضمن أن المستخدم المصادق عليه فقط هو الذي يمكنه إرسال طلب تحديث الملف الشخصي
    }

    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name'  => ['nullable', 'string', 'max:255'],

            'email'      => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],

            'phone'      => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('users', 'phone')->ignore($userId),
            ],

            'address'    => ['nullable', 'string', 'max:255'],
            'region_id'  => ['nullable', 'exists:regions,id'],
        ];
    }
}
