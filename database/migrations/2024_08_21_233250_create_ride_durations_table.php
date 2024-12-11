<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up(): void
    {
        Schema::create('ride_durations', function (Blueprint $table) {
            $table->id();
            $table->string('duration');
            $table->unsignedBigInteger('price');
            $table->boolean('stream')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ride_durations');
    }
};
