<?php

namespace Database\Factories;

use App\Models\EmploymentType;
use App\Models\job\JobTitle;
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
        return [
            'user_id'            => User::factory(),
            'job_title'          => JobTitle::all()->random()->name,
            'employment_type'    => EmploymentType::all()->random()->name,
            'company'            => $this->faker->company(),
            'location'           => $this->faker->address(),
            'starting_date'      => $this->faker->date(),
            'completion_date'    => $this->faker->date(),
            'is_current_job'     => $this->faker->randomElement([true, false]),
        ];
    }
}
