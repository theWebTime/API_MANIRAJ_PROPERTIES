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
        Schema::create('residential_floors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('residential_id');
            $table->foreign('residential_id')->references('id')->on('residentials');
            $table->string('floor', 200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residential_floors');
    }
};
