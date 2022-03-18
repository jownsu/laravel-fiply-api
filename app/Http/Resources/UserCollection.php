<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCollection extends JsonResource
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
            'id'            => $this->id,
            'fullname'      => $this->profile->fullname(),
            'avatar'        => $this->profile->avatar(),
            'preview'       => $preview

        ];
    }
}
