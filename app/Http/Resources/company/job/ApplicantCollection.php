<?php

namespace App\Http\Resources\company\job;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ApplicantCollection extends JsonResource
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
            'id'         => $this->pivot->id,
            'user_id'    => $this->id,
            'name'       => $this->profile->firstname . ' ' . $this->profile->lastname,
            'avatar'     => $this->profile->avatar(),
            'applied_at' => $this->pivot->created_at ? $this->pivot->created_at->diffForHumans() : null
        ];
    }
}
