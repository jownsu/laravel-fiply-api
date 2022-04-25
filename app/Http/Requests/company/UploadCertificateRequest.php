<?php

namespace App\Http\Requests\company;

use Illuminate\Foundation\Http\FormRequest;

class UploadCertificateRequest extends FormRequest
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
            'certificate'       => ['required', 'string'],
            'certificate_image' => ['required', 'mimes:jpg,jpeg,png,bmp,gif,svg,webp,pdf,docx', 'max:2048'],
        ];
    }
}
