<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class EducationalBackroundRequest extends FormRequest
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
            'school'            => ['required', 'min:2', 'max:255', 'string'],
            'degree'            => ['nullable', 'min:2', 'max:255', 'string'],
            'field_of_study'    => ['nullable', 'min:2', 'max:255', 'string'],
            'starting_date'     => ['required', 'date'],
            'completion_date'   => ['required', 'date']
        ];
    }
}
