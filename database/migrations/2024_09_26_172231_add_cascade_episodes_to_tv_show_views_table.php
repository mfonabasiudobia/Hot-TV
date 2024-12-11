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
            $table->dropForeign(['episode_id']);
            $table->dropForeign(['user_id']);


            $table->foreign('episode_id')
                ->references('id')->on('episodes')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
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
            $table->dropForeign(['episode_id']);
            $table->dropForeign(['user_id']);

            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->foreignId('episode_id')->nullable()->references('id')->on('episodes');
        });
    }
};
