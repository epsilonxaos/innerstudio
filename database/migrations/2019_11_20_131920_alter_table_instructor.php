<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableInstructor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instructor', function (Blueprint $table) {
            $table->string('color') -> nullable();
            $table->tinyInteger('status_externo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instructor', function (Blueprint $table) {
            $table->dropColumn('color');
            $table->dropColumn('status_externo');
        });
    }
}
