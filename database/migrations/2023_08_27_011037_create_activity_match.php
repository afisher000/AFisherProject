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
        Schema::create('activity_matches', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('activity_id1');
            $table->bigInteger('activity_id2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_matches');
    }
};
