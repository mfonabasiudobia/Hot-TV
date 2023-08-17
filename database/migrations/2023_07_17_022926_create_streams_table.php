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
        Schema::create('streams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->date('schedule_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('recorded_video')->nullable();
            $table->string('thumbnail')->nullable();
            $table->enum('stream_type', ['uploaded_video', 'podcast'])->default('uploaded_video');
            $table->softDeletes();
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
        Schema::dropIfExists('streams');
    }
};
