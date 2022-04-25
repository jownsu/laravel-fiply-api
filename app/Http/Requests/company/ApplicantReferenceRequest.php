<?php

namespace App\Http\Requests\company;

use Illuminate\Foundation\Http\FormRequest;

class ApplicantReferenceRequest extends FormRequest
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
            'level_of_experience'   => ['required', 'string', 'min:2', 'max:255'],
            'field_of_expertise'    => ['required', 'string', 'min:2', 'max:255'],
            'location'              => ['required', 'string', 'min:2', 'max:255']
        ];
    }
}
