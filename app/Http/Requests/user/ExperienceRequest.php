<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class ExperienceRequest extends FormRequest
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
            'job_title'         => ['required', 'min:5', 'max:255', 'string'],
            'employment_type'   => ['required', 'min:5', 'max:255', 'string'],
            'location'          => ['nullable', 'min:5', 'max:255', 'string'],
            'company'           => ['nullable', 'min:5', 'max:255', 'string'],
            'starting_date'     => ['required', 'date'],
            'completion_date'   => ['required', 'date']
        ];
    }
}
