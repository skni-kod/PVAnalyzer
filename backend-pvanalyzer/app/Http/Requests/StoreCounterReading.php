<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCounterReading extends FormRequest
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
            'date' => 'required|date',
            'active_energy_consumed' => 'required|numeric',
            'reactive_energy_consumed' => 'required|numeric',
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
            'date.date' => 'Data musi mieć odpowiedni format',
            'active_energy_consumed.numeric' => 'Energia pobrana musi być wartością liczbową',
            'reactive_energy_consumed.numeric' => 'Energia oddana musi być wartością liczbową',
        ];
    }
}
