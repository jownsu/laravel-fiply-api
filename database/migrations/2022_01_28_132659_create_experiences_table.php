<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users")
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string("job_title");
            $table->string("employment_type");
            $table->string("company")->nullable();
            $table->string("location")->nullable();
            $table->date("starting_date")->nullable();
            $table->date("completion_date")->nullable();
            $table->boolean('is_current_job')->default(false);
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
        Schema::dropIfExists('experiences');
    }
}
