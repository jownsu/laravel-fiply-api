<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id")
                ->constrained("companies")
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('valid_id')->nullable();
            $table->string('valid_id_image_front')->nullable();
            $table->string('valid_id_image_back')->nullable();
            $table->string('certificate')->nullable();
            $table->string('certificate_image')->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('company_documents');
    }
}
