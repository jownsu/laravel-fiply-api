<?php

namespace Database\Factories;

use App\Models\EmploymentType;
use App\Models\job\JobTitle;
use App\Models\location\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExperienceFactory extends Factory
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
            'user_id'            => User::factory(),
            'job_title'          => JobTitle::inRandomOrder()->first()->name,
            'employment_type'    => EmploymentType::inRandomOrder()->first()->name,
            'company'            => $this->faker->company(),
            'location'           => $location,
            'starting_date'      => $this->faker->date(),
            'completion_date'    => $this->faker->date(),
            'is_current_job'     => $this->faker->randomElement([true, false]),
        ];
    }
}
