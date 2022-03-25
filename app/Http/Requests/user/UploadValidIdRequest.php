<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class UploadValidIdRequest extends FormRequest
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
            'valid_id'             => ['required', 'string'],
            'valid_id_image_front' => ['required', 'image'],
            'valid_id_image_back'  => ['required', 'image']
        ];
    }
}
