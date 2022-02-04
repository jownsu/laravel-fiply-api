<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")
                ->constrained("users")
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('gender')->nullable();
            $table->date('birthday')->nullable();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('location')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('telephone_no')->nullable();
            $table->string('language')->nullable();
            $table->string('status')->nullable();
            $table->string('website')->nullable();
            $table->string('description')->nullable();
            $table->string('avatar')->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
