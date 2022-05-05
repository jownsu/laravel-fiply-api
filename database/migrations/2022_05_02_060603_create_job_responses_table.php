<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId("applied_job_id")
                ->constrained("applied_jobs")
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId("question_id")
                ->constrained("questions")
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('answer')->nullable();
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
        Schema::dropIfExists('job_responses');
    }
}
