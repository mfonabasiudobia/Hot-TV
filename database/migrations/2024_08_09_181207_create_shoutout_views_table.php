<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shoutout_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shoutout_id')->references('id')->on('shoutouts');
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shoutout_views');
    }
};
