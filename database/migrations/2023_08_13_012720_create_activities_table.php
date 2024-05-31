<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('athlete_id');
            $table->integer('elapsed_time');
            $table->string('name');
            $table->string('sport_type')->nullable();
            $table->decimal('total_elevation_gain',10,4)->nullable();
            $table->timestamp('start_date')->nullable();
            $table->decimal('start_lat',10,4)->nullable();
            $table->decimal('start_lng',10,4)->nullable();
            $table->decimal('average_speed',10,4)->nullable();
            $table->decimal('average_cadence',10,4)->nullable();
            $table->decimal('distance',10,4)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
