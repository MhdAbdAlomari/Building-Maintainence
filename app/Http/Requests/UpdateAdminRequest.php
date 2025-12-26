<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        // تأكد إنو المستخدم أدمن
        return $this->user() && $this->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'status' => ['sometimes', 'required', 'string', 'in:pending,accepted,on_the_way,complete,canceled'],
            'technician_id' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
           
        ];
    }
}
