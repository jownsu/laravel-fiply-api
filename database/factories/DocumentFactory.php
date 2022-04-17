<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    private static $resumeCount = 1;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'      => User::factory(),
            'resume'       => self::$resumeCount++ . '.pdf',
        ];
    }
}
