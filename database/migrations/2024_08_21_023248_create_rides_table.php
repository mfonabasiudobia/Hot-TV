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
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();;
            $table->foreignId('driver_id')->nullable()->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();;
            $table->string('duration');
            $table->unsignedBigInteger('price');
            $table->text('details');
            $table->string('ride_type');
            $table->string('street_name');
            $table->string('customer_latitude');
            $table->string('customer_longitude');
            $table->string('driver_latitude');
            $table->string('driver_longitude');
            $table->string('document_id');
            $table->string('status')->default(StatusEnum::REQUESTED->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
