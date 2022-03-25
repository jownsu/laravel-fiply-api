<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ValidIdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('valid_ids')->count()){
            DB::unprepared(file_get_contents(__DIR__ . '/sql/valid_ids.sql'));
        }
    }
}
