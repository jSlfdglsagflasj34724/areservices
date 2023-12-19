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
        Schema::create('asset_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('id')->on('assets')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('field_name', 100)->nullable();
            $table->string('field_value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_fields');
    }
};
