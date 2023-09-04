<?php

use Botble\Base\Enums\BaseStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->string('salary');
            $table->string('description', 400)->nullable();
            $table->text('content')->nullable();
            $table->integer('views')->default(0);
            $table->string('status')->default(BaseStatusEnum::PUBLISHED);
            $table->timestamps();
        });

        Schema::create('careers_translations', function (Blueprint $table) {
            $table->string('lang_code');
            $table->foreignId('careers_id');
            $table->string('name')->nullable();
            $table->string('location')->nullable();
            $table->string('salary')->nullable();
            $table->string('description', 400)->nullable();
            $table->text('content')->nullable();

            $table->primary(['lang_code', 'careers_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('careers');
        Schema::dropIfExists('careers_translations');
    }
};
