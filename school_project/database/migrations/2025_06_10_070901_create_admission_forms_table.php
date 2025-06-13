<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission_forms', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('parent_name');
            $table->string('gender');
            $table->string('dob');
            $table->string('roll')->nullable();
            $table->string('blood_group');
            $table->string('religion');
            $table->string('email')->nullable();
            $table->string('class');
            $table->string('section');
            $table->string('teacher_name');
            $table->string('admission_id')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('photo')->nullable(); // stores image path
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
        Schema::dropIfExists('admission_forms');
    }
}
