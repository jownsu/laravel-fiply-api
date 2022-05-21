<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Resources\Json\JsonResource;

class JobseekerRequestCollection extends JsonResource
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
            'id'                   => $this->id,
            'doc_id'               => $this->document->id,
            'email'                => $this->email,
            'name'                 => $this->profile->firstname . ' ' . $this->profile->lastname,
            'avatar'               => $this->profile->avatar(),
            'valid_id'             => $this->document->valid_id,
            'valid_id_image_front' => $this->document->valid_id_image_front(),
            'valid_id_image_back'  => $this->document->valid_id_image_back()
        ];
    }
}
