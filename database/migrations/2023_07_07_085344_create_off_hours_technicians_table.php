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
        Schema::create('off_hours_technicians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('technican_id');
            $table->foreign('technican_id')->references('id')->on('technicians')->onDelete('cascade');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->softDeletes();
            $table->boolean('status')->default(1)->comment('0 for not active , 1 for active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('off_hours_technicians');
    }
};
