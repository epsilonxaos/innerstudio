<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cupon', function (Blueprint $table) {
            $table->bigIncrements('id_cupon');
            $table->integer('id_package')->nullable()->default(0);
            $table->string('title', 50);
            $table->tinyInteger('type')->comment('1=porcentaje,2=efectivo');
            $table->decimal('discount', 10,2)->default(0.00);
            $table->enum('directed', ['publico', 'paquete'])->default('publico');
            $table->date('start');
            $table->date('end');
            $table->integer('limit_use')->default(0);
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('cupon');
    }
}
