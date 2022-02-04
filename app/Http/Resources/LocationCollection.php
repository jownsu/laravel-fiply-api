<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $region   = $this->province->region->name;
        $province = $this->province->name;
        $city     = $this->name;
        $fullName = $city . ", " . $province . ", " . $region;

        return [
            'id'   => $this->id,
            'name' => $fullName,
            'city' => $city
        ];
    }
}
