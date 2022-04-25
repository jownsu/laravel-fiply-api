<?php

namespace App\Http\Resources\company;

use Illuminate\Http\Resources\Json\JsonResource;

class HiringManagerCollection extends JsonResource
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
            'firstname'  => $this->firstname,
            'lastname'   => $this->lastname,
            'name'       => $this->firstname . ' ' . $this->lastname,
            'email'      => $this->email,
            'contact_no' => $this->contact_no,
            'avatar'     => $this->avatar()
        ];
    }
}
