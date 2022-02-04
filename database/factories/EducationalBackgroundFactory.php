<?php

namespace Database\Factories;

use App\Models\job\JobCategory;
use App\Models\University;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EducationalBackgroundFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'           => User::factory(),
            'school'            => University::all()->random()->name,
            'degree'            => "Bachelor of " . ucfirst($this->faker->word()) .  " in " . ucfirst($this->faker->word()),
            'field_of_study'    => JobCategory::all()->random()->name,
            'starting_date'     => $this->faker->date(),
            'completion_date'   => $this->faker->date(),
        ];
    }
}
