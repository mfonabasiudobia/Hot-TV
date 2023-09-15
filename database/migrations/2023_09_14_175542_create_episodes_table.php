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
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("slug");
            $table->longText("description");
            $table->string("season_number");
            $table->string("episode_number");
            $table->string("duration");
            $table->string("thumbnail");
            $table->string("recorded_video");
            $table->json("tags");
            $table->dateTime("release_date")->nullable();
            $table->foreignId('tv_show_id')->nullable()->references('id')->on('tv_shows')->onDelete('cascade');
            $table->enum('status', ['published', 'unpublished'])->default('published');
            $table->softDeletes();
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
        Schema::dropIfExists('episodes');
    }
};
