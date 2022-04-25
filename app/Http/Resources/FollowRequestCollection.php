<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FollowRequestCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $preview = '';

        if($this->jobPreference()->exists()){
            $preview = $this->jobPreference->job_title;
        }

        return [
            'id'                     => $this->id,
            'name'                   => $this->profile ? $this->profile->fullname() : $this->company->name,
            'email'                  => $this->email,
            'preview'                => $preview,
            'avatar'                 => $this->profile ? $this->profile->avatar() : $this->company->avatar()
        ];
    }
}
