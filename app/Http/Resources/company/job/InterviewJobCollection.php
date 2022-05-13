<?php

namespace App\Http\Resources\company\job;

use Illuminate\Http\Resources\Json\JsonResource;

class InterviewJobCollection extends JsonResource
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
            'hiring_manager_id' => $this->hiring_manager_id,
            'title'             => $this->title,
            'name'              => $this->hiringManager->firstname . ' ' . $this->hiringManager->lastname,
            'avatar'            => $this->hiringManager->avatar(),
            'applicants_count'  => $this->users_count,
            'posted_at'         => $this->updated_at->diffForHumans()
        ];
    }
}
