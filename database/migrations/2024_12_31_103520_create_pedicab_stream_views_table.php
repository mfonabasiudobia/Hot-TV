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
        Schema::create('pedicab_stream_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ride_id')->references('id')->on('rides');
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->string('ip_address')->nullable();
            $table->enum('status', ['watching', 'left'])->nullable();
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
        Schema::dropIfExists('pedicab_stream_views');
    }
};
