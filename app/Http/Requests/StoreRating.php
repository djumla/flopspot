<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Validator;

class StoreRating extends FormRequest
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
            'entrance' => 'required|string',
            'exit' => 'required|string',
            'trainNumber' => 'required|string|regex:/(^[A-Za-z0-9 ]+$)+/',
            'rating' => 'required|integer|max:3'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
          'entrance.required' => 'Einstieg kann nicht leer sein.',
          'exit.required'  => 'Ausstieg kann nicht leer sein.',
          'trainNumber.required' => 'Zugnummer kann nicht leer sein.',
          'trainNumber.regex' => 'Ungülitges Format',
          'rating.required' => 'Rating kann nicht leer sein.'
        ];
    }
}
