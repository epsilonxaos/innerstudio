<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->bigIncrements('id_customer');
            $table->string('name', '80') -> nullable();
            $table->string('lastname', '80') -> nullable();
            $table->string('phone', '45') -> nullable();
            $table->string('email', '100');
            $table->string('password', '191');
            $table->date('birthdate')->nullable();
            $table->string('address', '100')->nullable();
            $table->string('city', '45')->nullable();
            $table->string('state', '45')->nullable();
            $table->string('country', '45')->nullable();
            $table->string('zip', '10')->nullable();
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
        Schema::dropIfExists('customer');
    }
}
