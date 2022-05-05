<?php

namespace App\Http\Resources\company\applicant;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResponseCollection extends JsonResource
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
            'question'    => $this->question->question,
            'answer'      => $this->answer
        ];
    }
}
