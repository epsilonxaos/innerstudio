<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePurchase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase', function (Blueprint $table) {
            $table->bigIncrements('id_purchase');
            $table->integer('id_customer');
            $table->integer('id_package');
            $table->decimal('price', 10, 2);
            $table->integer('no_class');
            $table->integer('use_class')->nullable()->default(0);
            $table->integer('duration');
            $table->tinyInteger('status')->nullable()->default(0);
            $table->tinyInteger('view')->nullable()->default();
            $table->string('reference_code',250)->nullable();
            $table->dateTime('date_expirate')->nullable();
            $table->dateTime('date_payment')->nullable();
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
        Schema::dropIfExists('purchase');
    }
}
