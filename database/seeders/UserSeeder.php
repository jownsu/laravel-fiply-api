<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\EducationalBackground;
use App\Models\Experience;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(25)
            ->has(Profile::factory()->count(1))
            ->has(Experience::factory()->count(2))
            ->has(EducationalBackground::factory()->count(1))
            ->has(Post::factory()->count(3))
            ->has(Comment::factory()->count(5))
            ->create();


    }
}
