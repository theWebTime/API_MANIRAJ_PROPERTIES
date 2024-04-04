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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo', 300)->nullable();
            $table->string('email1', 100)->nullable();
            $table->string('email2', 100)->nullable();
            $table->string('phone_number1', 15)->nullable();
            $table->string('phone_number2', 15)->nullable();
            $table->text('address')->nullable();
            $table->text('iframe')->nullable();
            $table->text('video_link')->nullable();
            $table->string('facebook_link', 200)->nullable();
            $table->string('instagram_link', 200)->nullable();
            $table->string('youtube_link', 200)->nullable();
            $table->string('whatsapp_number', 15)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
