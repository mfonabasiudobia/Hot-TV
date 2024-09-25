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
        Schema::table('show_category_tv_show', function (Blueprint $table) {
            $table->dropForeign(['show_category_id']);
            $table->dropForeign(['tv_show_id']);

            $table->foreign('show_category_id')
                ->references('id')->on('show_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('tv_show_id')
                ->references('id')->on('tv_shows')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('show_category_tv_show', function (Blueprint $table) {
            $table->dropForeign(['show_category_id']);
            $table->dropForeign(['tv_show_id']);

            $table->foreign('show_category_id')
                ->references('id')->on('show_categories');

            $table->foreign('tv_show_id')
                ->references('id')->on('tv_shows');
        });
    }
};
