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
        Schema::table('job_technicians', function (Blueprint $table) {
            if (Schema::hasColumn('job_technicians', 'technican_id')) {
                // The "job_technicians" table exists and has an "technican_id" column...
                $table->dropForeign(['technican_id']);
                $table->foreign('technican_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_technicians', function (Blueprint $table) {
            $table->dropForeign(['technican_id']);
        });
    }
};
