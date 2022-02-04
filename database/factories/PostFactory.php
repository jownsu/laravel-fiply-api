<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'   => User::factory(),
            'content'   => $this->faker->realText(200),
            'image'     => $this->faker->randomElement([null, 'https://placeimg.com/640/480/any'])
        ];
    }
}
