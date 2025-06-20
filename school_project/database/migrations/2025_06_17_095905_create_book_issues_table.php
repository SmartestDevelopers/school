<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_issues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->string('lender_name', 255);
            $table->string('lender_designation', 50); // Student, Teacher, Admin Staff
            $table->string('lender_class', 50)->nullable(); // For students
            $table->string('lender_section', 50)->nullable(); // For students
            $table->string('lender_roll_number', 50)->nullable(); // For students
            $table->date('issuance_date');
            $table->date('tentative_return_date');
            $table->date('return_date')->nullable();
            $table->enum('status', ['issued', 'returned'])->default('issued');
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
        Schema::dropIfExists('book_issues');
    }
}
