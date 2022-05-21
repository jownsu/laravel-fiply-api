<?php

namespace App\Http\Resources\user;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                   => $this->id,
            'valid_id'             => $this->valid_id,
            'valid_id_image_front' => $this->valid_id_image_front(),
            'valid_id_image_back'  => $this->valid_id_image_back(),
            'resume'               => $this->resume(),
            'status'               => $this->status,
        ];
    }
}
