<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_changes', function (Blueprint $table) {
            $table->id();
            $table->dateTime('change_time')->nullable(false);
            $table->decimal('base_delta', 128, 2, true)->nullable(false);
            $table->smallInteger('base_currency_id', false, true)->nullable(false);
            $table->decimal('national_delta', 128, 2, true)->nullable(false);
            $table->smallInteger('national_currency_id', unsigned: true)->nullable(false);
            $table->bigInteger('user_id', false, true)->nullable(false);
            $table->string('type', 10)->nullable(false)->default('decrease');
            $table->integer('receiver_id', false, true)->nullable(false);
            $table->smallInteger('source_id', unsigned: true)->nullable(false);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('source_id')->references('id')->on('change_source');
            $table->foreign('base_currency_id')->references('id')->on('currency');
            $table->foreign('national_currency_id')->references('id')->on('currency');
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
        Schema::dropIfExists('balance_changes');
    }
}
