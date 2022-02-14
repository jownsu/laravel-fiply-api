<?php

namespace App\Http\Resources\vote;

use Illuminate\Http\Resources\Json\JsonResource;

class VoteCollection extends JsonResource
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
            'id'          => $this->id,
            'user_votes'  => UserCollection::collection($this->userVotes),
        ];
    }
}
