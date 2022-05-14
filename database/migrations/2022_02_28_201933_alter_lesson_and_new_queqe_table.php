<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLessonAndNewQueqeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailq', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_class');
            $table->integer('id_user');
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
        });
        //
        Schema::table('lesson', function (Blueprint $table) {
            $table->text('descripcion')->nullable();
            $table->string('color','100')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mailq');

        //
        Schema::table('lesson', function (Blueprint $table) {
            $table->dropColumn('descripcion');
            $table->dropColumn('color');
        });
    }
}
