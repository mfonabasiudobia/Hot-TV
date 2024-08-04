<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_plan_id')->constained('subscription_plans')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('status');
            $table->string('name', 255);
            $table->bigInteger('price');
            $table->string('stripe_plan_id')->nullable();
            $table->string('paypal_plan_id')->nullable();
            $table->timestamps();
        });

        Schema::create('subscritions_translations', function (Blueprint $table) {
            $table->string('lang_code');
            $table->foreignId('subscritions_id');
            $table->string('name', 255)->nullable();

            $table->primary(['lang_code', 'subscritions_id'], 'subscritions_translations_primary');
        });

        Schema::create('subscription_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('amount');
            $table->foreignId('user_id')->constained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('payment_method_type')->default('stripe');
            $table->string('session_id');
            $table->bigInteger('tax_amount')->nullable();
            $table->bigInteger('sub_total');
            $table->string('coupon_code')->nullable();
            $table->bigInteger('discount_amount')->nullable();
            $table->text('discount_description')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        
        Schema::dropIfExists('subscription_orders');
        Schema::dropIfExists('subscritions');
        Schema::dropIfExists('subscritions_translations');
    }
};
