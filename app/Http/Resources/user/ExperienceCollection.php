<?php

namespace App\Http\Resources\user;

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
            'employment_type' => $this->employment_type,
            'company'         => $this->company,
            'location'        => $this->location,
            'starting_date'   => $this->starting_date ? $this->starting_date->format('F d, Y') : null,
            'completion_date' => $this->completion_date ? $this->completion_date->format('F d, Y') : null,
            'is_current_job'  => $this->is_current_job
        ];
    }
}
