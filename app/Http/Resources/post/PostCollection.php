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
            'posted_by'          => $this->user->profile ? $this->user->profile->fullname() : $this->user->company->name,
            'avatar'             => $this->user->profile ? $this->user->profile->avatar() : $this->user->company->avatar(),
            'content'            => $this->content,
            'image'              => $this->image(),
            'date'               => $this->updated_at->diffForHumans(),
            'upVotes_count'      => $this->total_upVotes,
            'comments_count'     => $this->comments_count,
            'is_upVoted'         => $this->is_upVoted ? true : false,
            'is_public'          => $this->is_public ? true: false,
            'comments'           => CommentCollection::collection($this->whenLoaded('comments')),
        ];
    }
}
