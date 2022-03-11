<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class JobPreferenceRequest extends FormRequest
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
            'job_title'         => ['required', 'string', 'min:5', 'max:255'],
            'location'          => ['required', 'string', 'min:5', 'max:255'],
            'employment_type'   => ['required', 'string', 'min:5', 'max:255']
        ];
    }
}
