<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradeCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_coins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('adopt_id');
            $table->enum('type', ['auction', 'sale']);
            $table->enum('status', ['on', 'off']);
            $table->time('end_bit')->nullable();
            $table->time('last_time')->nullable();
            $table->double('each_bit')->default(1)->nullable();
            $table->double('auto_buy')->default(0)->nullable();
            $table->double('start_price')->default(0)->nullable();
            $table->double('end_price')->default(0)->nullable();
            $table->softDeletes();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('adopt_id')->references('id')->on('adopts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trade_coins');
    }
}
