<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProfile extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'min:8',
            'email' => 'email|unique:users,email',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.unique' => 'Istnieje konto o podanym emailu.',
            'email.email' => 'To nie jest format adresu mailowego',
            'name.min' => 'Nazwa użytkownika musi mieć min 8 znaków',
        ];
    }
}
