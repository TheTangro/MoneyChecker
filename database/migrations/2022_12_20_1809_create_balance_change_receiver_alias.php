<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceChangeReceiverAlias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_change_receiver_alias', function (Blueprint $table) {
            $table->string('alias', 255)->nullable(false)->unique();
            $table->integer('receiver_id')->nullable(true);
            $table->foreign('receiver_id')->references('id')->on('balance_change_receiver');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balance_change_receiver_alias');
    }
}
