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
            'entrance' => 'required|string|exists:train_stations,station',
            'exit' => 'required|string|exists:train_stations,station',
            'trainNumber' => 'required|string|exists:train_numbers,trainNumber',
            'trainNumber' => array('regex: /^(ICE|ice) \d+$/ '),
            'date' => 'required|date_format:Y-m-d',
            'rating' => 'required|integer|regex:/[1-3]/',
            'response' => 'required|recaptcha'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'entrance.required' => 'Einstieg kann nicht leer sein.',
            'entrance.exists' => 'Einstieg wurde nicht gefunden.',
            'exit.required' => 'Ausstieg kann nicht leer sein.',
            'exit.exists' => 'Ausstieg wurde nicht gefunden.',
            'trainNumber.required' => 'Zugnummer kann nicht leer sein.',
            'trainNumber.regex' => 'Ungültiges Format.',
            'trainNumber.exists' => 'Zugnummer wurde nicht gefunden.',
            'date.required' => 'Datum kann nicht leer sein.',
            'date.date_format' => 'Ungültiges Format.',
            'rating.required' => 'Bitte geben Sie Ihre Zufriedenheit an.',
            'rating.regex' => 'Ungültiges Format.',
            'response.recaptcha' => 'Bitte verifizieren Sie sich als Mensch.'
        ];
    }
}
