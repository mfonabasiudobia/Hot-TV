<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ride_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ride_id');
            $table->string('user_latitude')->nullable();
            $table->string('user_longitude')->nullable();
            $table->timestamp('event_timestamp');
            $table->enum('event_type', ['started', 'completed', 'accepted', 'driver_arrived', 'driver_not_found', 'cancelled', 'payment_success', 'payment_failed']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ride_events');
    }
};
