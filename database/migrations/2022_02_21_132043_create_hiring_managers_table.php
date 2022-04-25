<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHiringManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hiring_managers', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id")
                ->constrained("companies")
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('firstname');
            $table->string('lastname');
            //$table->string('position')->nullable();
            $table->string('email');
            $table->string('contact_no')->nullable();
            $table->string('avatar')->nullable();
            $table->string('code')->nullable();
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
        Schema::dropIfExists('hiring_managers');
    }
}
