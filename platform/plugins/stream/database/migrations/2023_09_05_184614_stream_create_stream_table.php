<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('streams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->date('schedule_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('recorded_video')->nullable();
            $table->string('thumbnail')->nullable();
            $table->enum('stream_type', ['uploaded_video', 'podcast'])->default('uploaded_video');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('streams_translations', function (Blueprint $table) {
            $table->string('lang_code');
            $table->foreignId('streams_id');
            $table->string('name', 255)->nullable();

            $table->primary(['lang_code', 'streams_id'], 'streams_translations_primary');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('streams');
        Schema::dropIfExists('streams_translations');
    }
};
