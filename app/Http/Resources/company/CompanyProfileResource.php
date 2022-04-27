<?php

namespace App\Http\Resources\company;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $account_level = $this->account_level();

        return [
            'id'                    => $this->id,
            'email'                 => $this->email,
            'avatar'                => $this->company->avatar(),
            'cover'                 => $this->company->cover(),
            'name'                  => $this->company->name,
            'location'              => $this->company->location,
            'following_count'       => $this->following_count,
            'followers_count'       => $this->followers_count,
            'is_following'          => $this->is_following ? true : false,
            'is_following_pending'  => $this->is_following_pending ? true : false,
            'account_level'         => $account_level['account_level'],
            'account_level_str'     => $account_level['account_level_str'],
            'bio'                   => $this->company->bio,
            'is_me'                 => $this->is_me,
            'is_public'             => $this->is_public ? true : false,
            'company'               => $this->company->id
        ];
    }
}
