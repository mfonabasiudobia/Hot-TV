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
        Schema::create('cast_tv_show', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cast_id')->nullable()->references('id')->on('casts');
            $table->foreignId('tv_show_id')->references('id')->on('tv_shows')->onDelete('cascade');
            $table->string('role'); 
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
        Schema::dropIfExists('cast_tv_show');
    }
};
