<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->longText('description');
            $table->string('thumbnail');
            $table->string('video_trailer');
            $table->dateTime('release_date');
            $table->foreignId('tv_show_id')->references('id')->on('tv_shows')->cascadeOnUpdate()->cascadeOnDelete();;
            $table->string('status');
            $table->string("tags");
            $table->string('meta_title');
            $table->text('meta_description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seasons');
    }
};
