<?php

namespace App\Http\Requests\company;

use Illuminate\Foundation\Http\FormRequest;

class UploadCompanyIdRequest extends FormRequest
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
            'valid_id_image_front' => ['required', 'mimes:jpg,jpeg,png,bmp,gif,svg,webp,pdf,docx', 'max:5000'],
            'valid_id_image_back'  => ['required', 'mimes:jpg,jpeg,png,bmp,gif,svg,webp,pdf,docx', 'max:5000']
        ];
    }
}
