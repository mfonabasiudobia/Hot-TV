<?php


use App\Enums\Ride\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->references('id')->on('users');
            $table->string('duration');
            $table->unsignedBigInteger('price');
            $table->text('details');
            $table->string('ride_type');
            $table->string('street_name');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('status')->default(StatusEnum::INITIATED->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
