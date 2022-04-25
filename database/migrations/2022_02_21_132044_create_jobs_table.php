<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hiring_manager_id')
                ->constrained('hiring_managers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('title');
            $table->string('employment_type');
            $table->string('location');
            $table->string('position_level');
            $table->string('specialization')->nullable();
            $table->text('job_responsibilities');
            $table->text('qualifications');
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
        Schema::dropIfExists('jobs');
    }
}
