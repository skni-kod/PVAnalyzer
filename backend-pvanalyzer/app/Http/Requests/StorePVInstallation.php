<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePVInstallation extends FormRequest
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
            'date' => 'nullable|date',
            'power' => 'required|numeric|min:1'
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
            'date.date' => 'Data podłączenia instalacji musi mieć odpowiedni format',
            'power.numeric' => 'Moc instalacji musi być wartością liczbową',
            'power.min' => 'Moc instalacji musi być większa od 1.',
        ];
    }
}
