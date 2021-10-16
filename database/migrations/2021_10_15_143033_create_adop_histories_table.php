<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdopHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adop_histories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('status', ['OTA', 'DTA']);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('trans_user');
            $table->unsignedBigInteger('adopt_id')->nullable();
            $table->unsignedBigInteger('trans_adopt')->nullable();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('trans_user')->references('id')->on('users');
            $table->foreign('adopt_id')->references('id')->on('adopts')->onUpdate('cascade');
            $table->foreign('trans_adopt')->references('id')->on('adopts')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adop_histories');
    }
}
