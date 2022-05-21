<?php

namespace App\Http\Resources\admin;

use App\Http\Resources\company\CompanyDocumentResource;
use App\Http\Resources\company\HiringManagerCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyProfileResource extends JsonResource
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
            'id'               => $this->id,
            'company_id'       => $this->company->id,
            'email'            => $this->email,
            'avatar'           => $this->company->avatar(),
            'cover'            => $this->company->cover(),
            'name'             => $this->company->name,
            'registration_no'  => $this->company->registration_no,
            'telephone_no'     => $this->company->telephone_no,
            'location'         => $this->company->location,
            'bio'              => $this->company->bio,
            'hiring_managers'  => $this->when(
                            $this->company->relationLoaded('hiringManagers') && $this->company->relationLoaded('hiringManagers'),
                                    function () {
                                        return HiringManagerCollection::collection($this->company->hiringManagers);
                                    }),
            'document'         => $this->when(
                                $this->company->relationLoaded('companyDocument') && $this->company->relationLoaded('companyDocument'),
                                function () {
                                    return new CompanyDocumentResource($this->company->companyDocument);
                                })

        ];
    }
}
