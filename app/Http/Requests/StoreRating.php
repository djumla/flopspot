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
            'trainNumber' => 'required|string|regex:[ICE \d]',
            'rating' => 'required|integer|regex:/[1-3]/'
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
          'trainNumber.regex' => 'Ungülitges Format.',
          'rating.required' => 'Bitte geben Sie Ihre Zufriedenheit an.',
          'rating.regex' => 'Ungültiges Format.'
        ];
    }
}
