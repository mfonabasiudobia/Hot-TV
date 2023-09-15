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
        Schema::create('show_category_tv_show', function (Blueprint $table) {
            $table->id();
            $table->foreignId('show_category_id')->references('id')->on('show_categories');
            $table->foreignId('tv_show_id')->references('id')->on('tv_shows');
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
        Schema::dropIfExists('show_category_tv_show');
    }
};
