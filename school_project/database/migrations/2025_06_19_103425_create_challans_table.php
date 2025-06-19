<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challans', function (Blueprint $table) {
            $table->id();
            $table->string('school_name');
            $table->string('class');
            $table->string('section');
            $table->string('student_name');
            $table->string('father_name')->nullable();
            $table->string('gr_number')->nullable();
            $table->string('academic_session');
            $table->integer('year');
            $table->string('from_month');
            $table->integer('from_year');
            $table->string('to_month')->nullable();
            $table->integer('to_year')->nullable();
            $table->decimal('total_fee', 10, 2);
            $table->string('status')->default('pending');
            $table->string('issued_on');
            $table->string('due_date');
            $table->string('amount_in_words');
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
        Schema::dropIfExists('challans');
    }
}
