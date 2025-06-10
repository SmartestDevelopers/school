<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_forms', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_name');
            $table->string('id_no')->nullable();
            $table->string('gender')->nullable();
            $table->string('class')->nullable();
            $table->string('subject')->nullable();
            $table->string('section')->nullable();
            $table->string('time')->nullable();
            $table->string('date')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('class_forms');
    }
}
