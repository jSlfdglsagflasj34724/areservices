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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_type_id')->nullable()->index();
            $table->string('brand_name')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('model')->nullable();
            $table->string('barcode_url')->nullable();
            $table->integer('year')->nullable();
            $table->string('other_asset_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
