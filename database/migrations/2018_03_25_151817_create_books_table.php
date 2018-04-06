<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->timestamps();
            $table->string('title_book');
            $table->string('description', 10000)->nullable();
            $table->string('author')->nullable();
            $table->date('publication_date')->comment('Дата издания книги')->nullable();
            $table->date('creation_date')->comment('Дата написания произведения')->nullable();
            $table->string('publisher')->comment('Издательство')->nullable();
            $table->integer('pages_count')->nullable();
            $table->integer('in_all')->comment('Количество имеющихся книг')->nullable();
            $table->string('inventory_number')->nullable();
            $table->string('image', 200)->nullable()->default('storage/app/public/book_images/cover.png');
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
