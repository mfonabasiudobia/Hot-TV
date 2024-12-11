<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class () extends Migration {
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('status');
            $table->timestamps();
        });

        
        Schema::create('subscription_plans_translations', function (Blueprint $table) {
            $table->string('lang_code');
            $table->foreignId('subscription_plans_id');
            $table->string('name', 255)->nullable();

            $table->primary(['lang_code', 'subscription_plans_id'], 'subscription_plans_translations_primary');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
        Schema::dropIfExists('subscription_plans_translations');
        
        
        
    }
};
