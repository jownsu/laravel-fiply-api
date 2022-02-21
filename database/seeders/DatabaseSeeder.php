<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            JobCategorySeeder::class,
            JobTitleSeeder::class,
            UniversitySeeder::class,
            LocationRegionSeeder::class,
            LocationProvinceSeeder::class,
            LocationCitySeeder::class,
            EmploymentTypeSeeder::class,
            DegreeSeeder::class,
            PositionLevelSeeder::class,
            UserSeeder::class,
        ]);

        foreach (Post::all() as $post){
            $users = User::inRandomOrder()->take(rand(1,10))->get('id');
            foreach($users as $user){
                $post->userUpVotes()->attach($user);
            }
        }
    }
}
