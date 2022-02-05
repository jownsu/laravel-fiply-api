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
    public function definition()
    {
        return [
            'user_id'      => User::factory(),
            'gender'       => $this->faker->randomElement(['Male', 'Female']),
            'birthday'     => $this->faker->dateTimeBetween('-40 years', 'now'),
            'firstname'    => $this->faker->firstName(),
            'middlename'   => $this->faker->randomElement([$this->faker->lastName(), '']),
            'lastname'     => $this->faker->lastName(),
            'location'     => $this->faker->address(),
            'mobile_no'    => $this->faker->e164PhoneNumber(),
            'telephone_no' => $this->faker->phoneNumber(),
            'language'     => $this->faker->randomElement(['English', 'Filipino']),
            'status'       => $this->faker->randomElement(['Looking for a job', 'Employed']),
            'website'      => $this->faker->domainName(),
            'description'  => $this->faker->catchPhrase(),
        ];
    }
}