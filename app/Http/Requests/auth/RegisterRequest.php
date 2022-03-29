<?php

namespace App\Http\Requests\auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
/*        'email|required|string|unique:users,email'*/
        return [
            'email'             => ['email', 'required', 'max:255', 'string',  Rule::unique(User::class)],
            'password'          => [
                                    'required',
                                    'confirmed',
                                    'string',
                                    'max:255',
                                    Password::min(8)
                                        ->letters()
                                        ->mixedCase()
                                        ->numbers()
                                        ->symbols()
                                    ],
            'firstname'         => ['required', 'string', 'min:2', 'max:255'],
            'lastname'          => ['required', 'string', 'min:2',  'max:255'],
            'birthday'          => ['required'],
            'code'              => ['required', 'min:6', 'max:6'],

            'job_preference'                   => ['nullable', 'array'],
            'job_preference.job_title'         => ['required_with:job_preference', 'string', 'min:2', 'max:255'],
            'job_preference.location'          => ['required_with:job_preference', 'string', 'min:2', 'max:255'],
            'job_preference.employment_type'   => ['required_with:job_preference', 'string', 'min:2', 'max:255']

        ];
    }
}
