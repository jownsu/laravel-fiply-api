<?php

namespace App\Http\Resources\user;

use Illuminate\Http\Resources\Json\JsonResource;

class EducationalBackgroundCollection extends JsonResource
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
            'id'                => $this->id,
            'school'            => $this->school,
            'degree'            => $this->degree,
            'field_of_study'    => $this->field_of_study,
            'starting_date'     => $this->starting_date->format('F d, Y'),
            'completion_date'   => $this->completion_date->format('F d, Y')
        ];
    }
}
