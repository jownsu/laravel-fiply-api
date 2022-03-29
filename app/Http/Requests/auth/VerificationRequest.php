<?php

namespace App\Http\Requests\auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class VerificationRequest extends FormRequest
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
            'email'           => ['email', 'required', 'max:255', 'string',  Rule::unique(User::class)],
            'password'        => [
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
            'firstname'       => ['required', 'string', 'max:255'],
            'lastname'        => ['required', 'string', 'max:255'],
        ];
    }
}
