<?php

namespace App\Http\Requests\post;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'content'   => ['required_without:image'],
            'image'     => ['required_without:content', 'image'],
            'is_public' => ['nullable', 'boolean']
        ];
    }
}
