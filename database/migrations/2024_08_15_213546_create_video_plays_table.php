<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('video_plays', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->integer('played_seconds');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('video_plays');
    }
};
