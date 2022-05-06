<?php

namespace App\Http\Requests\company;

use Illuminate\Foundation\Http\FormRequest;

class HiringManagerRequest extends FormRequest
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
            'firstname'     => ['required', 'min:2', 'max:255', 'string'],
            'lastname'      => ['required', 'min:2', 'max:255', 'string'],
            'email'         => ['required', 'min:2', 'max:255', 'string'],
            'contact_no'    => ['required', 'min:2', 'max:255', 'string'],
            'code'          => ['required', 'numeric', 'min:0000', 'max:9999'],
            'avatar'        => ['nullable', 'image', 'max:5000'],
        ];
    }
}
