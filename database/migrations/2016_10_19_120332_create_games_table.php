<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('route', 50);
            $table->string('file_token', 32);
            $table->integer('width');
            $table->integer('height');
            $table->string('server_url');
            $table->integer('server_port');
            $table->string('server_api');
            $table->boolean('jackpot');
            $table->integer('order');
            $table->tinyInteger('category')->unsigned();
            $table->tinyInteger('status')->unsigned();

            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('games');
    }
}
