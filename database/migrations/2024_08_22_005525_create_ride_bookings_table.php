<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Ride\PaymentStatusEnum;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ride_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ride_id')->references('id')->on('rides')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('order_id')->nullable()->references('id')->on('ec_orders');
            $table->string('payment_status')->default(PaymentStatusEnum::PAYMENT_PENDING->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ride_bookings');
    }
};
