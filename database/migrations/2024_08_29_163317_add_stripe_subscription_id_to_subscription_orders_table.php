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
        Schema::table('subscription_orders', function (Blueprint $table) {
            $table->string('stripe_subscription_id')->nullable()->after('subscription_id');
            $table->string('paypal_subscription_id')->nullable()->after('stripe_subscription_id');
            $table->timestamp('trial_ended_at')->nullable()->after('paypal_subscription_id');
            $table->boolean('current_subscription')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription_orders', function (Blueprint $table) {
            $table->dropColumn('current_subscription');
            $table->dropColumn('trial_ended_at');
            $table->dropColumn('paypal_subscription_id');
            $table->dropColumn('stripe_subscription_id');
        });
    }
};
