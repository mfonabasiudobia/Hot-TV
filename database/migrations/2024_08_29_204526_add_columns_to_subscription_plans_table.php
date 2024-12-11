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
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->string('interval')->after('name');
            $table->boolean('trail')->default(false)->after('interval');
            $table->string('trail_period_stripe')->nullable()->after('trail');
            $table->text('trail_period_paypal')->nullable()->after('trail_period_stripe');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn('trail_period_paypal');
            $table->dropColumn('trail_period_stripe');
            $table->dropColumn('trail');
            $table->dropColumn('interval');
        });
    }
};
