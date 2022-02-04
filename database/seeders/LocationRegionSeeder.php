<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationRegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('location_regions')->count()) {
            DB::unprepared(file_get_contents(__DIR__ . '/sql/location_regions.sql'));
        }
    }
}
