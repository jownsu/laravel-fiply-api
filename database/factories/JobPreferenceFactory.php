<?php

namespace Database\Factories;

use App\Models\EmploymentType;
use App\Models\job\JobTitle;
use App\Models\location\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobPreferenceFactory extends Factory
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
            'user_id'           => User::factory(),
            'job_title'         => JobTitle::inRandomOrder()->first()->name,
            'location'          => $location,
            'employment_type'   => EmploymentType::inRandomOrder()->first()->name,
        ];
    }
}
