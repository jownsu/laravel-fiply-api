<?php

namespace App\Http\Resources\user;

use App\Models\User;
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
        $preview = '';
        if($this->jobPreference()->exists()){
            $preview = $this->jobPreference->job_title;
        }

        $account_level = $this->account_level();


        return [
            'id'                    => $this->id,
            'email'                 => $this->email,
            'gender'                => $this->profile->gender,
            'birthday'              => $this->profile->birthday ? $this->profile->birthday->format('F d, Y') : null,
            'fullname'              => $this->profile->fullname(),
            'firstname'             => $this->profile->firstname,
            'middlename'            => $this->profile->middlename,
            'lastname'              => $this->profile->lastname,
            'age'                   => $this->profile->age(),
            'location'              => $this->profile->location,
            'mobile_no'             => $this->profile->mobile_no,
            'telephone_no'          => $this->profile->telephone_no,
            'language'              => $this->profile->language,
            'status'                => $this->profile->status,
            'preview'               => $preview,
            'account_level'         => $account_level['account_level'],
            'account_level_str'     => $account_level['account_level_str'],
            'website'               => $this->profile->website,
            'description'           => $this->profile->description,
            'avatar'                => $this->profile->avatar(),
            'cover'                 => $this->profile->cover(),
            'following_count'       => $this->following_count,
            'followers_count'       => $this->followers_count,
            'is_following'          => $this->is_following ? true : false,
            'is_following_pending'  => $this->is_following_pending ? true : false,
            'is_me'                 => $this->is_me
        ];
    }
}
