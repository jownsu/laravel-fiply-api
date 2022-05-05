<?php

namespace App\Http\Resources\company\applicant;

use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceCollection extends JsonResource
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
            'id'              => $this->id,
            'job_title'       => $this->job_title,
            'company'         => $this->company,
            'starting_date'   => $this->starting_date,
            'completion_date' => $this->completion_date,
        ];
    }
}
