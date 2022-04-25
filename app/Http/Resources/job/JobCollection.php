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
            'company'           => $this->hiringManager->company->name,
            'location'          => $this->hiringManager->company->location,
            'posted_at'         => $this->created_at->diffForHumans(),
            'avatar'            => $this->hiringManager->company->avatar(),
            'is_applied'        => $this->userAppliedJobs->first() ? true : false,
            'is_saved'          => $this->userSavedJobs->first() ? true : false,
        ];
    }
}
