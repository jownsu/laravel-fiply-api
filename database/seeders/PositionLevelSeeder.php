<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('position_levels')->count()){
            DB::unprepared(file_get_contents(__DIR__ . '/sql/position_level.sql'));
        }
    }
}
