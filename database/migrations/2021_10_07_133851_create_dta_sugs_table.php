<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDtaSugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dta_sugs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trade_id');
            $table->unsignedBigInteger('user_id');
            $table->string('path');
            $table->integer('size');
            $table->integer('width');
            $table->integer('height');
            $table->boolean('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('trade_id')->references('id')->on('trade_adops');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dta_sugs');
    }
}
