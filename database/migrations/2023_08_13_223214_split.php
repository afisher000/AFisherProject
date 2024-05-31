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
        Schema::create('splits', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('activity_id');
            $table->bigInteger('athlete_id');
            $table->decimal('lat', 10, 4);
            $table->decimal('lng', 10, 4);
            $table->decimal('grade', 10, 4);
            $table->decimal('speed', 10, 4);
            $table->decimal('altitude', 10, 4);
            $table->integer('hr')->nullable();
            $table->integer('split');
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
