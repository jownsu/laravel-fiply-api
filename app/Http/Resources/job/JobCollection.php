<?php

namespace App\Http\Resources\job;

use Illuminate\Http\Resources\Json\JsonResource;

class JobCollection extends JsonResource
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
            'id'                => $this->id,
            'title'             => $this->title,
            'employment_type'   => $this->employment_type,
            'image'             => $this->image(),
            'company'           => $this->company,
            'location'          => $this->location,
            'posted_at'         => $this->created_at->diffForHumans()
        ];
    }
}
