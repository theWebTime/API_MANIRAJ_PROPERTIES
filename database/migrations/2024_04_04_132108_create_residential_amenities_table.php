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
        Schema::create('residential_amenities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('residentials_id');
            $table->foreign('residentials_id')->references('id')->on('residentials');
            $table->unsignedBigInteger('amenities_id');
            $table->foreign('amenities_id')->references('id')->on('amenities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residential_amenities');
    }
};