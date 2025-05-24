<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAdImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('ad_images');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('ad_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ad_id');
            $table->foreign('ad_id')->references('id')->on('ads')->onDelete('cascade');
            $table->string('image');
        });
    }
}
