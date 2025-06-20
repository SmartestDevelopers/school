<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesTable extends Migration
{
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fee_group_id');
            $table->string('class');
            $table->string('section');
            $table->string('month');
            $table->integer('year');
            $table->string('academic_year');
            $table->string('fee_type');
            $table->decimal('fee_amount', 10, 2);
            $table->timestamps();
            $table->foreign('fee_group_id')->references('id')->on('fee_groups')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fees');
    }
}