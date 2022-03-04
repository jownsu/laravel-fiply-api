<?php

namespace App\Http\Requests\auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'password'        => ['required', 'confirmed', 'string', 'max:255'],
            'firstname'       => ['required', 'string', 'max:255'],
            'lastname'        => ['required', 'string', 'max:255'],
        ];
    }
}
