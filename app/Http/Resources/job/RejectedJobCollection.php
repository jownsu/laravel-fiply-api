<?php

namespace App\Http\Resources\job;

use Illuminate\Http\Resources\Json\JsonResource;

class RejectedJobCollection extends JsonResource
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
            'id'                      => $this->id,
            'title'                   => $this->title,
            'employment_type'         => $this->employment_type,
            'hiring_manager'          => $this->hiringManager->firstname . ' ' . $this->hiringManager->lastname,
            'hiring_manager_avatar'   => $this->hiringManager->avatar(),
            'avatar'                  => $this->hiringManager->company->avatar(),
            'company'                 => $this->hiringManager->company->name,
            'location'                => $this->hiringManager->company->location,
            'remarks'                 => $this->pivot->remarks,
            'posted_at'               => $this->created_at->diffForHumans(),
        ];
    }
}
