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
            'trainNumber' => 'required|string',
            'rating' => 'required|integer|max:3'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
          'entrance.required' => 'Einstieg eingeben!',
          'exit.required'  => 'Ausstieg eingeben!',
          'trainNumber.required' => 'Zugnummer eingeben!',
          'rating.required' => 'Anklicken, man!'
        ];
    }
}
