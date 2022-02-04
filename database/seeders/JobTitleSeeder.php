<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('job_titles')->count()){
            DB::unprepared(file_get_contents(__DIR__ . '/sql/job_titles.sql'));
        }
    }
}
