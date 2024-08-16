<?php

use Botble\SubscriptionOrder\Enums\OrderStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('subscription_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('amount');
            $table->foreignId('subscription_id')->constained('subscriptions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->constained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('payment_method_type')->default('stripe');
            $table->string('session_id');
            $table->bigInteger('tax_amount')->nullable();
            $table->bigInteger('sub_total');
            $table->string('coupon_code')->nullable();
            $table->bigInteger('discount_amount')->nullable();
            $table->text('discount_description')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default(OrderStatusEnum::PENDING->value);
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
