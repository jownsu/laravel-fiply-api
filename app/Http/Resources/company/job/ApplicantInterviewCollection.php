<?php

namespace App\Http\Resources\company\job;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantInterviewCollection extends JsonResource
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
            'id'         => $this->pivot->id,
            'user_id'    => $this->id,
            'name'       => $this->profile->firstname . ' ' . $this->profile->lastname,
            'avatar'     => $this->profile->avatar(),
            'applied_at' => $this->pivot->created_at ? $this->pivot->created_at->diffForHumans() : null,
            'remarks'    => $this->pivot->remarks ?? null,
            'meet_date'  => $dateStr ?? null,
            'meet_time'  => $timeStr ?? null,
        ];
    }
}
