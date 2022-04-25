<?php

namespace Database\Seeders;

use App\Models\ApplicantPreference;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Document;
use App\Models\EducationalBackground;
use App\Models\Experience;
use App\Models\HiringManager;
use App\Models\Job;
use App\Models\JobPreference;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(30)
            ->has(
                Company::factory()->count(1)
                    ->has(ApplicantPreference::factory()->count(1))
                    ->has(HiringManager::factory()->count(5)
                        ->has(Job::factory()->count(5))
                    )
            )
            ->has(Post::factory()->count(3))
            ->has(Comment::factory()->count(5))
            ->create();

        //Job::factory()->count(5)->forHiringManager()->create();

    }
}
