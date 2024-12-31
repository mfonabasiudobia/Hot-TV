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
        Schema::table('rides', function (Blueprint $table) {
            $table->string('stream_channel_token')->default(false);
            $table->boolean('stream')->default(false);
            $table->string('stream_channel_name')->nullable();
            $table->boolean('is_stream_blocked')->default(false);
            $table->enum('stream_status', ['streaming', 'completed'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->dropColumn('stream', 'stream_channel_name', 'is_stream_blocked', 'is_stream_ended');
        });
    }
};
