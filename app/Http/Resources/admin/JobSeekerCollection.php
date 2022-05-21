<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Resources\Json\JsonResource;

class JobSeekerCollection extends JsonResource
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
            'id'              => $this->id,
            'email'           => $this->email,
            'name'            => $this->profile->firstname . ' ' . $this->profile->lastname,
            'avatar'          => $this->profile->avatar(),
        ];
    }
}
