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
            'code'              => ['required', 'min:6', 'max:6'],

            'profile'                   => ['nullable', 'array'],
            'profile.firstname'         => ['required_with:profile', 'string', 'min:2', 'max:255'],
            'profile.lastname'          => ['required_with:profile', 'string', 'min:2',  'max:255'],
            'profile.birthday'          => ['required_with:profile'],

            'job_preference'                   => ['nullable', 'array'],
            'job_preference.job_title'         => ['required_with:job_preference', 'string', 'min:2', 'max:255'],
            'job_preference.location'          => ['required_with:job_preference', 'string', 'min:2', 'max:255'],
            'job_preference.employment_type'   => ['required_with:job_preference', 'string', 'min:2', 'max:255'],

            'company'                   => ['nullable', 'array'],
            'company.name'              => ['required_with:company', 'string', 'min:2', 'max:255'],
            'company.registration_no'   => ['required_with:company', 'string', 'min:2', 'max:255'],
            'company.telephone_no'      => ['nullable', 'string', 'min:2', 'max:255'],
            'company.location'          => ['required_with:company', 'string', 'min:2', 'max:255'],
            'company.code'              => ['required_with:company', 'numeric', 'min:0000', 'max:9999'],

            'applicant_preference'                      => ['nullable', 'array'],
            'applicant_preference.level_of_experience'  => ['required_with:applicant_preference', 'string', 'min:2', 'max:255'],
            'applicant_preference.field_of_expertise'   => ['required_with:applicant_preference', 'string', 'min:2', 'max:255'],
            'applicant_preference.location'             => ['required_with:applicant_preference', 'string', 'min:2', 'max:255'],

        ];
    }
}
