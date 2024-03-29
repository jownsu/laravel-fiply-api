<?php

namespace Database\Factories;

use App\Models\location\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    private static $img = 1;
    private static $cover = 1;

    public function definition()
    {
        $city = City::with('province.region')->inRandomOrder()->first();
        $location = $city->name . ', ' . $city->province->name . ', ' . $city->province->region->name;

        return [
            'user_id'      => User::factory(),
            'gender'       => $this->faker->randomElement(['Male', 'Female']),
            'birthday'     => $this->faker->dateTimeBetween('-40 years', 'now'),
            'firstname'    => $this->faker->firstName(),
            'lastname'     => $this->faker->lastName(),
            'location'     => $location,
            'mobile_no'    => $this->faker->e164PhoneNumber(),
            'telephone_no' => $this->faker->phoneNumber(),
            'language'     => $this->faker->randomElement(['English', 'Filipino']),
            'website'      => "https://" . $this->faker->domainName(),
            'bio'          => $this->faker->catchPhrase(),
            'avatar'       => self::$img++ . '.jpeg',
            'cover'        => self::$cover++ . '.jpg',
        ];
    }
}
