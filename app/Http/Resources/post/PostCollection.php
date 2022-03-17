<?php

namespace App\Http\Resources\post;

use Illuminate\Http\Resources\Json\JsonResource;

class PostCollection extends JsonResource
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
            'id'                 => $this->id,
            'user_id'            => $this->user->id,
            'posted_by'          => $this->user->profile->fullname(),
            'avatar'             => $this->user->profile->avatar(),
            'content'            => $this->content,
            'image'              => $this->image(),
            'date'               => $this->updated_at->diffForHumans(),
            'upVotes_count'      => $this->userUpVotes->count(),
            'is_upVoted'         => $this->userUpVotes->contains(auth()->id()) ? true : false,
            'comments'           => CommentCollection::collection($this->whenLoaded('comments')),
        ];
    }
}
