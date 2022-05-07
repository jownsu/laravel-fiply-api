<?php

namespace App\Http\Requests\job;

use Illuminate\Foundation\Http\FormRequest;

class ApplyJobRequest extends FormRequest
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
            'job_id'                => ['required'],
            'answers'               => ['nullable', 'array', 'min:1'],
            'answers.*.question_id' => ['required_with:answers'],
            'answers.*.answer'      => ['required_with:answers', 'min:1', 'max:255'],
        ];
    }
}
