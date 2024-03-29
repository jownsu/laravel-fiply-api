<?php

namespace App\Http\Resources\company\job;

use App\Http\Resources\company\applicant\EducationalBackgroundCollection;
use App\Http\Resources\company\applicant\ExperienceCollection;
use App\Http\Resources\company\applicant\JobResponseCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        if($this->meet_date){
            $time = strtotime($this->meet_date);

            $dateStr = date('M d, Y',$time);
            $timeStr = date('g:i A',$time);
        }
        return [
            'id'                        => $this->id,
            'user_id'                   => $this->user_id,
            'name'                      => $this->user->profile->firstname . ' ' . $this->user->profile->lastname,
            'location'                  => $this->user->profile->location,
            'avatar'                    => $this->user->profile->avatar(),
            'resume'                    => $this->user->document->resume(),
            'experiences'               => ExperienceCollection::collection($this->user->experiences),
            'educational_backgrounds'   => EducationalBackgroundCollection::collection($this->user->educationalBackgrounds),
            'job_responses'             => JobResponseCollection::collection($this->jobResponses),
            'remarks'                   => $this->remarks ?? null,
            'meet_date'                 => $dateStr ?? null,
            'meet_time'                 => $timeStr ?? null,
        ];
    }
}
