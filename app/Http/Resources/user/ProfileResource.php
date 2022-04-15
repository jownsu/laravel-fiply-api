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
            //$preview = 'Looking For ' . $this->jobPreference->job_title . ' Job';
            $preview = $this->jobPreference->job_title;
        }
        $account_level = $this->account_level();

        $moreInfo = ($this->is_following || $this->is_public || $this->is_me) ? [
            'birthday'              => $this->profile->birthday ? $this->profile->birthday->format('F d, Y') : null,
            'age'                   => $this->profile->age(),
            'gender'                => $this->profile->gender,
            'location'              => $this->profile->location,
            'mobile_no'             => $this->profile->mobile_no,
            'telephone_no'          => $this->profile->telephone_no,
            'language'              => $this->profile->language,
            'status'                => $this->profile->status,
            'website'               => $this->profile->website,
        ] : [];





        return array_merge([
            'id'                    => $this->id,
            'email'                 => $this->email,
            'fullname'              => $this->profile->fullname(),
            'firstname'             => $this->profile->firstname,
            'middlename'            => $this->profile->middlename,
            'lastname'              => $this->profile->lastname,
            'avatar'                => $this->profile->avatar(),
            'cover'                 => $this->profile->cover(),
            'following_count'       => $this->following_count,
            'followers_count'       => $this->followers_count,
            'is_following'          => $this->is_following ? true : false,
            'is_following_pending'  => $this->is_following_pending ? true : false,
            'preview'               => $preview,
            'account_level'         => $account_level['account_level'],
            'account_level_str'     => $account_level['account_level_str'],
            'description'           => $this->profile->description,
            'is_me'                 => $this->is_me,
            'is_public'             => $this->is_public ? true : false
        ], $moreInfo);
    }
}
