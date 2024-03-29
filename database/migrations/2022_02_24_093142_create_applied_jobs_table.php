<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppliedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applied_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id',)->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('job_id')->references('id')->on('jobs')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->dateTime("meet_date")->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('reject')->default(false);
            $table->boolean('result')->default(false);
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('applied_jobs');
    }
}
