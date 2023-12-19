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
        Schema::table('notifications', function (Blueprint $table) {
            if (!(Schema::hasColumn('notifications', 'job_id'))) {
                $table->foreignId('job_id')->constrained()->onDelete('cascade');
            }
            if (!(Schema::hasColumn('notifications', 'type'))) {
                $table->string('type')->nullable();
            }
            if (!(Schema::hasColumn('notifications', 'read_at'))) {
                $table->timestamp('read_at')->nullable();
            }
            if (!(Schema::hasColumn('notifications', 'deleted_at'))) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_technicians', function (Blueprint $table) {
            if (Schema::hasTable('notifications')) {
                // The "notifications" table exists...
                $table->dropForeign(['job_id']);
                $table->dropColumn(['type', 'read_at']);
            }
        });
    }
};
