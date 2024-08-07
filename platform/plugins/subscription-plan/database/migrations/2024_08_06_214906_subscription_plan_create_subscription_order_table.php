<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('subscription_orders', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('subscription_orders_translations', function (Blueprint $table) {
            $table->string('lang_code');
            $table->foreignId('subscription_orders_id');
            $table->string('name', 255)->nullable();

            $table->primary(['lang_code', 'subscription_orders_id'], 'subscription_orders_translations_primary');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_orders');
        Schema::dropIfExists('subscription_orders_translations');
    }
};
