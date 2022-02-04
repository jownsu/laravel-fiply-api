<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('degrees')->count()){
            DB::unprepared(file_get_contents(__DIR__ . '/sql/degrees.sql'));
        }
    }
}
