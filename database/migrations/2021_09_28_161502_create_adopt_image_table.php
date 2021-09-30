<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdoptImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adopt_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('adopt_id');
            $table->string('path');
            $table->string('type');
            $table->integer('size');
            $table->integer('width');
            $table->integer('height');
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('adopt_image');
    }
}
