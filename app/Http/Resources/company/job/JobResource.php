<?php

namespace App\Http\Resources\company\job;

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
            'hiring_manager_id'     => $this->hiring_manager_id,
            'hiring_manager'        => $this->hiringManager->firstname . ' ' . $this->hiringManager->lastname,
            'hiring_manager_avatar' => $this->hiringManager->avatar(),
            'company_name'          => $this->hiringManager->company->name,
            'company_avatar'        => $this->hiringManager->company->avatar(),
            'title'                 => $this->title,
            'employment_type'       => $this->employment_type,
            'location'              => $this->location,
            'position_level'        => $this->position_level,
            'specialization'        => $this->specialization,
            'job_responsibilities'  => $this->job_responsibilities,
            'qualifications'        => $this->qualifications,
            'posted_at'             => $this->updated_at->diffForHumans(),
            'applicants_count'      => $this->users_count
            //'applicants'            => ApplicantCollection::collection($this->whenLoaded('users')),
        ];
    }
}
