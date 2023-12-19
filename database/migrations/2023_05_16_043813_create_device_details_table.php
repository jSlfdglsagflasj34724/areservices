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
        Schema::create('device_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('device_identifier')->nullable();
            $table->string('platform')->nullable();
            $table->string('device_model')->nullable();
            $table->string('device_name')->nullable();
            $table->string('system_version')->nullable();
            $table->string('app_verson')->nullable();
            $table->string('app_verson_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_details');
    }
};
