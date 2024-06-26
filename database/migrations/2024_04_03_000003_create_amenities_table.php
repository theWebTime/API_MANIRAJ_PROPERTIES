<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80)->unique();
            $table->text('description')->nullable();
            $table->boolean('status')->default(1)->comment("1 for active and 0 for in-active");
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('amenities');
    }
};
