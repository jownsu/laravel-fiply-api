<?php

namespace App\Http\Resources\admin;

use App\Http\Resources\user\DocumentResource;
use App\Http\Resources\user\EducationalBackgroundCollection;
use App\Http\Resources\user\ExperienceCollection;
use App\Models\Experience;
use Illuminate\Http\Resources\Json\JsonResource;

class JobseekerProfileResource extends JsonResource
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
            'id'                      => $this->id ,
            'email'                   => $this->email ,
            'gender'                  => $this->profile->gender ,
            'birthday'                => $this->profile->birthday ? $this->profile->birthday->format('F d, Y') : null,
            'age'                     => $this->profile->age(),
            'name'                    => $this->profile->fullname(),
            'firstname'               => $this->profile->firstname,
            'lastname'                => $this->profile->lastname,
            'location'                => $this->profile->location,
            'mobile_no'               => $this->profile->mobile_no,
            'telephone_no'            => $this->profile->telephone_no,
            'language'                => $this->profile->language,
            'website'                 => $this->profile->website,
            'bio'                     => $this->profile->bio,
            'avatar'                  => $this->profile->avatar(),
            'cover'                   => $this->profile->cover(),
            'educational_backgrounds' => EducationalBackgroundCollection::collection($this->whenLoaded('educationalBackgrounds')),
            'experiences'             => ExperienceCollection::collection($this->whenLoaded('experiences')),
            'document'                => new DocumentResource($this->whenLoaded('document'))
        ];
    }
}
