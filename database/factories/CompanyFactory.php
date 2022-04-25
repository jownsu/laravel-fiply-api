<?php

namespace Database\Factories;

use App\Models\location\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{

    private static $cover = 31;
    private static $img = 31;

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
            'name'               => $this->faker->company(),
            'registration_no'    => $this->faker->creditCardNumber(),
            'telephone_no'       => $this->faker->e164PhoneNumber(),
            'location'           => $location,
            'bio'                => $this->faker->catchPhrase(),
            'avatar'             => self::$img++ . '.jpeg',
            'cover'              => self::$cover++ . '.jpg',
        ];
    }
}
