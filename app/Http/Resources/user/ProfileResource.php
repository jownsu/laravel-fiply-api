<?php

namespace App\Http\Resources\user;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'id'           => $this->id,
            'email'        => $this->email,
            'gender'       => $this->profile->gender,
            'birthday'     => $this->profile->birthday,
            'fullname'     => $this->profile->fullname(),
            'age'          => $this->profile->age(),
            'location'     => $this->profile->location,
            'mobile_no'    => $this->profile->mobile_no,
            'telephone_no' => $this->profile->telephone_no,
            'language'     => $this->profile->language,
            'status'       => $this->profile->status,
            'website'      => $this->profile->website,
            'description'  => $this->profile->description,
            'avatar'       => $this->profile->avatar
        ];
    }
}
