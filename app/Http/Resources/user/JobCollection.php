<?php

namespace App\Http\Resources\user;

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
        if($this->pivot->meet_date){
            $time = strtotime($this->pivot->meet_date);

            $dateStr = date('M d, Y',$time);
            $timeStr = date('g:i A',$time);
        }

        return [
            'id'                => $this->id,
            'title'             => $this->title,
            'employment_type'   => $this->employment_type,
            'avatar'            => $this->hiringManager->company->avatar(),
            'company'           => $this->hiringManager->company->name,
            'location'          => $this->hiringManager->company->location,
            'meet_date'         => $dateStr ?? null,
            'meet_time'         => $timeStr ?? null,
            'posted_at'         => $this->created_at->diffForHumans(),
        ];
    }
}
