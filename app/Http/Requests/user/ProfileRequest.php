<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'gender'        => ['nullable', 'min:2', 'max:255', 'string'],
            'birthday'      => ['nullable', 'date'],
            'firstname'     => ['required', 'min:2', 'max:255', 'string'],
            'middlename'    => ['nullable', 'min:2', 'max:255', 'string'],
            'lastname'      => ['required', 'min:2', 'max:255', 'string'],
            'location'      => ['nullable', 'min:2', 'max:255', 'string'],
            'mobile_no'     => ['nullable', 'min:2', 'max:255', 'string'],
            'telephone_no'  => ['nullable', 'min:2', 'max:255', 'string'],
            'language'      => ['nullable', 'min:2', 'max:255', 'string'],
            'status'        => ['nullable', 'min:2', 'max:255', 'string'],
            'website'       => ['nullable', 'min:2', 'max:255', 'string'],
            'description'   => ['nullable', 'min:2', 'max:255', 'string'],
            //'avatar'        => ['nullable', 'min:2', 'max:255', 'string'],
        ];
    }
}
