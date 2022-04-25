<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\job\JobCategory;
use App\Models\location\City;
use App\Models\PositionLevel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicantPreferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $city = City::with('province.region')->inRandomOrder()->first();
        $location = $city->name . ', ' . $city->province->name . ', ' . $city->province->region->name;
        return [
            'company_id'          => Company::factory(),
            'level_of_experience' => PositionLevel::inRandomOrder()->first()->name,
            'field_of_expertise'  => JobCategory::inRandomOrder()->first()->name,
            'location'            => $location,
        ];
    }
}
