<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameClicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_clicks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('app_id')->unsigned();
            $table->integer('member_id')->unsigned();
            $table->integer('game_id')->unsigned();
            $table->string('platform', 50);
            $table->string('browser', 50);
            $table->string('ip_address', 39);
            $table->timestamp('clicked_at');

            $table->foreign('app_id')->references('id')->on('apps');
            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('game_id')->references('id')->on('games');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('game_clicks');
    }
}
