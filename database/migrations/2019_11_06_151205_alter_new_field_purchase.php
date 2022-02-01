<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNewFieldPurchase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase', function (Blueprint $table) {
            $table->enum('method_pay', ['tarjeta', 'efectivo']) -> nullable();
            $table->decimal('discount',10,2) -> nullable()->default(0.00);
        });

        Schema::table('purchase_data', function (Blueprint $table) {
            $table->string('cupon_name', 50) -> nullable();
            $table->tinyInteger('cupon_type') -> nullable()->default(0);
            $table->decimal('cupon_value', 10,2) -> nullable()->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase', function (Blueprint $table) {
            $table->dropColumn('method_pay');
            $table->dropColumn('discount');
        });

        Schema::table('purchase_data', function (Blueprint $table) {
            $table->dropColumn('cupon_name');
            $table->dropColumn('cupon_type');
            $table->dropColumn('cupon_value');
        });
    }
}
