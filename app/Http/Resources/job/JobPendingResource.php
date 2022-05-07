<?php

namespace App\Http\Resources\job;

use Illuminate\Http\Resources\Json\JsonResource;

class JobPendingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->pivot->meet_date){
            $time = strtotime($this->pivot->meet_date);

            $dateStr = date('M d, Y',$time);
            $timeStr = date('g:i A',$time);
        }

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
            'remarks'                  => $this->pivot->remarks,
            'meet_date'                => $dateStr ?? null,
            'meet_time'                => $timeStr ?? null,
            'posted_at'                => $this->created_at->diffForHumans(),
        ];
    }
}
