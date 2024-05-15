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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('image', 300)->nullable();
            $table->string('title', 100)->nullable();
            $table->text('description')->nullable();
            $table->string('hand_of_experience', 10)->nullable();
            $table->string('million_square_feet', 10)->nullable();
            $table->string('units', 10)->nullable();
            $table->string('residential_property', 10)->nullable();
            $table->string('commercial_property', 10)->nullable();
            $table->string('plots', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};