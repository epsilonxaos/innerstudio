<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCustomerUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table -> integer('id_customer');
            $table -> dropColumn('name');
        });

        Schema::table('customer', function (Blueprint $table) {
            $table -> dropColumn('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table -> string('name');
            $table->dropColumn('id_customer');
        });

        Schema::table('customer', function (Blueprint $table) {
            $table -> string('password');
        });
    }
}
