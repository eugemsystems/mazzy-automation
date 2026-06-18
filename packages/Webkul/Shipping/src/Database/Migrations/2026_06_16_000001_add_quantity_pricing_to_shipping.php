<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasColumn('products', 'shipping_price')) {
            Schema::table('products', function (Blueprint $table) {
                $table->decimal('shipping_price', 12, 4)->default(0)->after('shipping_class_id');
            });
        }

        Schema::table('shipping_zones', function (Blueprint $table) {
            if (! Schema::hasColumn('shipping_zones', 'free_qty')) {
                $table->integer('free_qty')->default(0)->after('base_cost');
            }

            if (! Schema::hasColumn('shipping_zones', 'extra_unit_cost')) {
                $table->decimal('extra_unit_cost', 12, 4)->default(0)->after('free_qty');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('products', 'shipping_price')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('shipping_price');
            });
        }

        Schema::table('shipping_zones', function (Blueprint $table) {
            if (Schema::hasColumn('shipping_zones', 'free_qty')) {
                $table->dropColumn('free_qty');
            }

            if (Schema::hasColumn('shipping_zones', 'extra_unit_cost')) {
                $table->dropColumn('extra_unit_cost');
            }
        });
    }
};
