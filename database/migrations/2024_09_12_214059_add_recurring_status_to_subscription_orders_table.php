<?php

use Botble\SubscriptionOrder\Enums\RecurringStatusEnum;
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
            $table->dateTime('next_billing_date')->nullable();
            $table->string('recurring_status')->default(RecurringStatusEnum::NEW->value);
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
            $table->dropColumn('recurring_status');
            $table->dropColumn('next_billing_date');
        });
    }
};
