<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('tvshows', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('tvshows_translations', function (Blueprint $table) {
            $table->string('lang_code');
            $table->foreignId('tvshows_id');
            $table->string('name', 255)->nullable();

            $table->primary(['lang_code', 'tvshows_id'], 'tvshows_translations_primary');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tvshows');
        Schema::dropIfExists('tvshows_translations');
    }
};
