<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class HiringManagerFactory extends Factory
{
    //private static $img = 1;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id'   => Company::factory(),
            'firstname'    => $this->faker->firstName(),
            'lastname'     => $this->faker->lastName(),
            //'position'     => $this->faker->jobTitle(),
            'email'        => $this->faker->companyEmail(),
            'contact_no'   => $this->faker->e164PhoneNumber(),
            //'username'     => $this->faker->userName(),
            //'password'     => bcrypt('Password@1'),
            'avatar'       => $this->faker->randomNumber(1,30) . '.jpeg',
        ];
    }
}
