<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmploymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('employment_types')->count()){
            DB::unprepared(file_get_contents(__DIR__ . '/sql/employment_type.sql'));
        }
    }
}
