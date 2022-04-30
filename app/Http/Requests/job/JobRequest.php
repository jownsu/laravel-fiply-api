<?php

namespace App\Http\Requests\job;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobRequest extends FormRequest
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
            'title'                 => ['required'],
            'employment_type'       => ['required'],
            'location'              => ['required'],
            'position_level'        => ['required'],
            'specialization'        => ['nullable'],
            'job_responsibilities'  => ['required'],
            'qualifications'        => ['required'],

            'questions'               => ['nullable', 'array'],
            'questions.*.type'        => ['required_with:questions', 'numeric'],
            'questions.*.question'    => ['required_with:questions', 'string', 'min:2', 'max:255'],
            'questions.*.options'     => ['required_if:questions.*.type,2,3']
        ];
    }
}
