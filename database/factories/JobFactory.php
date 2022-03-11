<?php

namespace Database\Factories;

use App\Models\EmploymentType;
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
        $imgList = [
            '1.png',
            '2.png',
            '3.png',
            '4.png',
            '5.png',
            '6.png',
            '7.jpg',
            '8.jpg',
            '9.jpg',
            '10.jpg',
            '11.jpg',
            '12.jpg',
            '13.png',
            '14.png',
            '15.jpg',
            '16.png',
            '17.jpeg',
            '18.jpg',
            '19.jpg',
            '20.png',
        ];


        return [
            'user_id'               => User::factory(),
            'title'                 => JobTitle::inRandomOrder()->first()->name,
            'employment_type'       => EmploymentType::inRandomOrder()->first()->name,
            'image'                 => $this->faker->randomElement($imgList),
            'company'               => $this->faker->company(),
            'location'              => $this->faker->address(),
            'position_level'        => PositionLevel::inRandomOrder()->first()->name,
            'specialization'        => JobCategory::inRandomOrder()->first()->name,
            'job_responsibilities'  => $this->faker->realText(500, 3),
            'qualifications'        => $this->faker->realText(500, 3),
        ];
    }
}
