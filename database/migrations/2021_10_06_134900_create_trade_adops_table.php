<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradeAdopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_adops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('adopt_id');
            $table->enum('type', ['ota', 'dta']);
            $table->enum('status', ['on', 'off']);
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
        Schema::dropIfExists('trade_adop');
    }
}
