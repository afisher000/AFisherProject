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
        Schema::create('tiles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('activity_id');
            $table->bigInteger('athlete_id');
            $table->float('discrete_lat');
            $table->float('discrete_lng');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
