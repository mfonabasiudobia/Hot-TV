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
        Schema::create('tv_show_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tv_show_id')->references('id')->on('tv_shows');
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->foreignId('episode_id')->nullable()->references('id')->on('episodes');
            $table->string('ip_address')->nullable();
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
        Schema::dropIfExists('tv_show_views');
    }
};
