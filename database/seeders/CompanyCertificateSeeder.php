<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyCertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('company_certificates')->count()){
            DB::unprepared(file_get_contents(__DIR__ . '/sql/company_certificates.sql'));
        }
    }
}
