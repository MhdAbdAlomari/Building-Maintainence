<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTechnicianDetailRequest extends FormRequest
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
            // الفني يعدّل فقط هالحقول:
            'years_of_experience' => 'sometimes|integer|min:0|max:60',
            'skills_description'  => 'sometimes|string|max:2000',
             'name'     => 'sometimes|string|max:255',
             'email'    => 'sometimes|email|max:255|unique:users,email',
            'address'   => 'sometimes|string|max:255',


            // ممنوع يغيّر تخصصه بنفسه
            'service_id' => 'prohibited',
            'user_id'    => 'prohibited',
        ];
    }
}
