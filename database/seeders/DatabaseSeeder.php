<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Job;
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
            DegreeCategorySeeder::class,
            DegreeSeeder::class,
            PositionLevelSeeder::class,
            UserSeeder::class,
            ValidIdsSeeder::class,
            CompanyCertificateSeeder::class,
            CompanySeeder::class
        ]);

        foreach (Post::all() as $post){
            $users = User::inRandomOrder()->take(rand(1,10))->get('id');
            foreach($users as $user){
                $post->userUpVotes()->attach($user);
            }
        }

        foreach (Post::all() as $post){
            $users = User::inRandomOrder()->take(rand(1,10))->get('id');
            foreach($users as $user){
                $post->userSavedPosts()->attach($user);
            }
        }

 /*       foreach (Job::all() as $job){
            $users = User::inRandomOrder()->take(rand(1,10))->get('id');
            foreach($users as $user){
                $job->userAppliedJobs()->attach($user);
            }
        }

        foreach (Job::all() as $job){
            $users = User::inRandomOrder()->take(rand(1,10))->get('id');
            foreach($users as $user){
                $job->userSavedJobs()->attach($user);
            }
        }*/

        foreach (User::all() as $user1){
            $users = User::inRandomOrder()->take(20)->get('id');
            foreach($users as $user){
                $user1->following()->attach($user, ['accepted' => rand(0,1)]);
            }
        }


    }
}
