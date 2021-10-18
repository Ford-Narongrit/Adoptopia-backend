<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtaSugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ota_sugs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trade_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('adopt_id');
            $table->boolean('status');
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('trade_id')->references('id')->on('trades')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('adopt_id')->references('id')->on('adopts')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ota_sugs');
    }
}