<?php

namespace App\Http\Resources\job;

use Illuminate\Http\Resources\Json\JsonResource;

class  JobResource extends JsonResource
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
            'id'                       => $this->id,
            'hiring_manager_id'        => $this->hiring_manager_id,
            'company_id'               => $this->hiringManager->company_id,
            'title'                    => $this->title,
            'employment_type'          => $this->employment_type,
            'position_level'           => $this->position_level,
            'job_responsibilities'     => $this->job_responsibilities,
            'qualifications'           => $this->qualifications,
            'hiring_manager'           => $this->hiringManager->firstname . ' ' . $this->hiringManager->lastname,
            'hiring_manager_avatar'    => $this->hiringManager->avatar(),
            'company_avatar'           => $this->hiringManager->company->avatar(),
            'company_name'             => $this->hiringManager->company->name,
            'location'                 => $this->hiringManager->company->location,
            'posted_at'                => $this->created_at->diffForHumans(),
            'questionnaire'            => $this->questions_count > 0 ? true : false,
            'is_applied'               => $this->userAppliedJobs->first() ? true : false,
            'is_saved'                 => $this->userSavedJobs->first() ? true : false
        ];
    }
}
