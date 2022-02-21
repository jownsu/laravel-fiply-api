<?php

namespace App\Http\Resources\job;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
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
            'id'                    => $this->id,
            'user_id'               => $this->user->id,
            'email'                 => $this->user->email,
            'avatar'                => $this->user->profile->avatar,
            'fullname'              => $this->user->profile->fullname(),
            'title'                 => $this->title,
            'employment_type'       => $this->employment_type,
            'image'                 => $this->image(),
            'company'               => $this->company,
            'location'              => $this->location,
            'position_level'        => $this->position_level,
            'years_of_experience'   => $this->years_of_experience,
            'specialization'        => $this->specialization,
            'description'           => $this->description,
            'posted_at'             => $this->created_at->diffForHumans()
        ];
    }
}
