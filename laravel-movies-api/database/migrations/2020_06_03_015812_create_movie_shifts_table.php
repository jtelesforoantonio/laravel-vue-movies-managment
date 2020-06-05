<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_shifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('movie_id');
            $table->dateTime('date_time');
            $table->enum('status', ['A', 'I'])->default('A');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('movie_id')->references('id')->on('movies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie_shifts');
    }
}
