<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('can_download')->default(0);
            $table->boolean('can_stream')->default(0);
            $table->decimal('price', 24, 2)->default(0);
            $table->enum('discount_type', ['fixed', 'percent'])->default('percent');
            $table->unsignedTinyInteger('discount_value')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
