<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModulePermisosAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rol', function (Blueprint $table) {
            $table->bigIncrements('id_rol');
            $table->string('rol');
            $table->timestamps();
        });
        Schema::create('rol_permisos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_rol');
            $table->integer('id_permiso');
            $table->timestamps();
        });
        Schema::create('permisos', function (Blueprint $table) {
            $table->bigIncrements('id_permiso');
            $table->string('permiso');
            $table->string('placeholder');
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
        Schema::dropIfExists('rol');
        Schema::dropIfExists('admin_info');
        Schema::dropIfExists('rol_permisos');
        Schema::dropIfExists('permisos');
    }
}
