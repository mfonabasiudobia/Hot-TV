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
        Schema::table('tv_show_views', function (Blueprint $table) {
            $table->dropForeign(['tv_show_id']);

            $table->foreign('tv_show_id')
                ->references('id')->on('tv_shows')
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
        Schema::table('tv_show_views', function (Blueprint $table) {
            $table->dropForeign(['tv_show_id']);

            $table->foreign('tv_show_id')
                ->references('id')->on('tv_shows');
        });
    }
};
