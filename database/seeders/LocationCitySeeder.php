<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('location_cities')->count()) {
            DB::unprepared(file_get_contents(__DIR__ . '/sql/location_cities.sql'));
        }
    }
}
