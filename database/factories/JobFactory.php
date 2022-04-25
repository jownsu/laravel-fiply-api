<?php

namespace Database\Factories;

use App\Models\EmploymentType;
use App\Models\HiringManager;
use App\Models\job\JobCategory;
use App\Models\job\JobTitle;
use App\Models\PositionLevel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'hiring_manager_id'     => HiringManager::factory(),
            'title'                 => JobTitle::inRandomOrder()->first()->name,
            'employment_type'       => EmploymentType::inRandomOrder()->first()->name,
            'location'              => $this->faker->address(),
            'position_level'        => PositionLevel::inRandomOrder()->first()->name,
            'specialization'        => JobCategory::inRandomOrder()->first()->name,
            'job_responsibilities'  => $this->faker->realText(500, 3),
            'qualifications'        => $this->faker->realText(500, 3),
        ];
    }
}
