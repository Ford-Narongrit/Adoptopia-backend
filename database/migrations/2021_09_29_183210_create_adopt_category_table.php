<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdoptCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adopt_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('adopt_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->foreign('adopt_id')->references('id')->on('adopts');
            $table->foreign('category_id')->references('id')->on('categories');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adopt_category');
    }
}
