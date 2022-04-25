<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id")
                ->constrained("companies")
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('level_of_experience');
            $table->string('field_of_expertise');
            $table->string('location');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicant_preferences');
    }
}
