<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cms_pages', function (Blueprint $table) {
            $table->boolean('show_in_solutions')->default(false)->after('layout');
            $table->unsignedInteger('parent_id')->nullable()->after('show_in_solutions');
            $table->string('menu_label')->nullable()->after('parent_id');
            $table->integer('sort_order')->default(0)->after('menu_label');

            $table->foreign('parent_id')->references('id')->on('cms_pages')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('cms_pages', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['show_in_solutions', 'parent_id', 'menu_label', 'sort_order']);
        });
    }
};
