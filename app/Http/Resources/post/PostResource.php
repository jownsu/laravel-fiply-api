<?php

namespace App\Http\Resources\post;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'id'                 => $this->id,
            'avatar'             => $this->user->profile->avatar(),
            'content'            => $this->content,
            'image'              => $this->image(),
            'date'               => $this->updated_at->diffForHumans(),
            ];
    }
}
