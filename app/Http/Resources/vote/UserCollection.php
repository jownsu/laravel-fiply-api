<?php

namespace App\Http\Resources\vote;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCollection extends JsonResource
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
            'id'       => $this->id,
            'name'     => $this->profile ? $this->profile->fullname() : $this->company->name,
            'avatar'   => $this->profile ? $this->profile->avatar() : $this->company->avatar()
        ];
    }
}
