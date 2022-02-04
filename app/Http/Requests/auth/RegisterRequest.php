<?php

namespace App\Http\Requests\auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'email'           => ['email', 'required', 'max:255', 'string',  Rule::unique(User::class)],
            'password'        => ['required', 'confirmed', 'string', 'max:255'],
            'firstname'       => ['required', 'string', 'max:255'],
            'lastname'        => ['required', 'string', 'max:255'],
/*            'job_title'       => ['required', 'string', 'max:255'],
            'location'        => ['required', 'string', 'max:255'],
            'employment_type' => ['required', 'string', 'max:255']*/
        ];
    }
}
