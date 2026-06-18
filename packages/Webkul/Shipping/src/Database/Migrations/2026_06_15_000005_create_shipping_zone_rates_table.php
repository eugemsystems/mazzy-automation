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
        if (Schema::hasTable('shipping_zone_rates')) {
            return;
        }

        Schema::create('shipping_zone_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shipping_zone_id')->unsigned();
            $table->integer('shipping_class_id')->unsigned()->nullable();
            $table->integer('min_qty')->default(1);
            $table->integer('max_qty')->nullable();
            $table->decimal('cost', 12, 4)->default(0);
            $table->timestamps();

            $table->foreign('shipping_zone_id')
                ->references('id')
                ->on('shipping_zones')
                ->onDelete('cascade');

            $table->foreign('shipping_class_id')
                ->references('id')
                ->on('shipping_classes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_zone_rates');
    }
};
