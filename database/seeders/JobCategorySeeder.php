<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('job_categories')->count()){
            DB::unprepared(file_get_contents(__DIR__ . '/sql/job_categories.sql'));
        }
    }
}
