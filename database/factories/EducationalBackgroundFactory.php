<?php

namespace Database\Factories;

use App\Models\Degree;
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
            'university'        => University::inRandomOrder()->first()->name,
            'degree'            => Degree::inRandomOrder()->first()->name,
            'field_of_study'    => JobCategory::inRandomOrder()->first()->name,
            'starting_date'     => $this->faker->date(),
            'completion_date'   => $this->faker->date(),
        ];
    }
}
