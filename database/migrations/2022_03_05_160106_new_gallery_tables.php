<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewGalleryTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('galeria', function (Blueprint $table) {
            $table->bigIncrements('id_galeria');
            $table->string('name', '100')->nullable();
            $table->timestamps();
        });

        Schema::create('slide', function (Blueprint $table) {
            $table->bigIncrements('id_slide');
            $table->integer('id_gal');
            $table->string('slide', '200');
            $table->string('alt', '45')->nullable();
            $table->integer('order');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('galeria');
        Schema::dropIfExists('slide');


    }
}
