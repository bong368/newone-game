<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('app_id')->unsigned();
            $table->integer('member_id')->unsigned();
            $table->decimal('amount', 18, 2);
            $table->decimal('balance', 18, 2);
            $table->tinyInteger('type')->unsigned();
            $table->string('transaction_no', 32);
            $table->timestamp('transaction_at');

            $table->unique('transaction_no');
            $table->foreign('app_id')->references('id')->on('apps');
            $table->foreign('member_id')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transfers');
    }
}
