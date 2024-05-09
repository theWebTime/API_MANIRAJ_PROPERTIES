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
        Schema::create('residential_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('client_name', 50);
            $table->string('client_number', 15);
            $table->unsignedBigInteger('residential_id');
            $table->foreign('residential_id')->references('id')->on('residentials');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residential_inquiries');
    }
};
