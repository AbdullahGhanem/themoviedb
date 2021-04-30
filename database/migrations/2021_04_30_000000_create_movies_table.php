<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('imdb_id')->nullable();
            $table->string('title');
            $table->text('overview');
            $table->date('release_date')->nullable();
            $table->double('vote_average', 1)->nullable();
            $table->timestamps();
        });

        Schema::create('category_movie', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('movie_id');
            $table->foreign('movie_id')->on('movies')->references('id');

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->on('categories')->references('id');
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
        Schema::dropIfExists('movies');
    }
}