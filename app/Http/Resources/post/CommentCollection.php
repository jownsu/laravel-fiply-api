<?php

namespace App\Http\Resources\post;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentCollection extends JsonResource
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
            'id'            => $this->id,
            'user_id'       => $this->user_id,
            'commented_by'  => $this->user->profile->fullname(),
            'avatar'        => $this->user->profile->avatar,
            'content'       => $this->content,
            'date'          => $this->updated_at->diffForHumans(),
        ];
    }
}
