<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('subscription_features', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('subscrptions_subscription_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constained('subscriptions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('subscription_feature_id')->constained('subscriptions')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('subscription_features_translations', function (Blueprint $table) {
            $table->string('lang_code');
            $table->foreignId('subscription_features_id');
            $table->string('name', 255)->nullable();

            $table->primary(['lang_code', 'subscription_features_id'], 'subscription_features_translations_primary');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_features');
        Schema::dropIfExists('subscription_features_translations');
        Schema::dropIfExists('subscrptions_subscription_features');
    }
};
