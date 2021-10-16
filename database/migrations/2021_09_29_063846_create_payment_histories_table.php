<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('post_id')->nullable();
            $table->enum('status', ['deposit', 'withdraw', 'earn', 'spend']);
            $table->double('amount');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('trans_user')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('trans_user')->references('id')->on('users');
            // $table->foreign('post_id')->references('id')->on('trader_coin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_histories');
    }
}
