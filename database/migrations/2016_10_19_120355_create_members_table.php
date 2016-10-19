<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('app_id')->unsigned();
            $table->integer('parent_id')->unsigned();
            $table->string('username', 50);
            $table->string('nickname', 50);
            $table->string('password');
            $table->decimal('coin', 18, 2);
            $table->integer('take_rate');
            $table->tinyInteger('role')->unsigned();
            $table->tinyInteger('type')->unsigned();
            $table->tinyInteger('status')->unsigned();
            $table->string('access_token', 32);
            $table->timestamp('registered_at');
            $table->rememberToken();

            $table->unique(['app_id', 'username']);
            $table->unique('access_token');
            $table->foreign('app_id')->references('id')->on('apps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('members');
    }
}
