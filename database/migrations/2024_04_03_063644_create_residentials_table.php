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
        Schema::create('residentials', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->text('description')->nullable();
            $table->string('image', 300)->nullable();
            $table->unsignedBigInteger('type_of_property_id');
            $table->foreign('type_of_property_id')->references('id')->on('type_of_properties');
            $table->string('square_yard', 50);
            $table->string('price', 50);
            $table->string('possession', 50);
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->string('shop_square_feet', 50)->nullable();
            $table->text('iframe')->nullable();
            $table->text('location');
            $table->string('brochure', 400)->nullable();
            $table->boolean('status')->default(1)->comment("1 for active and 0 for in-active");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residentials');
    }
};
