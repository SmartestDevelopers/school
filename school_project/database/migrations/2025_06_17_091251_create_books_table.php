<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255); // Book title
            $table->string('author', 255); // Author name
            $table->string('category', 100); // e.g., Fiction, Non-Fiction
            $table->string('genre', 100); // e.g., Mystery, Sci-Fi
            $table->year('publication_year');
            $table->string('library_id', 50)->unique(); // Unique Library ID
            $table->date('entry_date');
            $table->boolean('is_issued')->default(false); // Issued or available
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
        Schema::dropIfExists('books');
    }
}
