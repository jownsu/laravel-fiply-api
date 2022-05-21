<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyRequestCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                     => $this->id,
            'doc_id'                 => $this->company->companyDocument->id,
            'company_id'             => $this->company->id,
            'email'                  => $this->email,
            'name'                   => $this->company->name,
            'avatar'                 => $this->company->avatar(),
            'valid_id_image_front'   => $this->company->companyDocument->valid_id_image_front(),
            'valid_id_image_back'    => $this->company->companyDocument->valid_id_image_back(),
            'certificate'            => $this->company->companyDocument->certificate,
            'certificate_image'      => $this->company->companyDocument->certificate_image(),
        ];
    }
}
