<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FollowCollection extends JsonResource
{

    protected $authId;

    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->authId = auth()->id();
    }


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
            'fullname'               => $this->profile->fullname(),
            'email'                  => $this->email,
            'preview'                => $preview,
            'avatar'                 => $this->profile->avatar(),
            'is_follower'            => $this->is_follower ? true : false,
            'is_follower_pending'    => $this->is_follower_pending ? true : false,
            'is_following'           => $this->is_following ? true : false,
            'is_following_pending'   => $this->is_following_pending ? true : false,
            'is_me'                  => $this->authId == $this->id ? true : false
        ];
    }
}
