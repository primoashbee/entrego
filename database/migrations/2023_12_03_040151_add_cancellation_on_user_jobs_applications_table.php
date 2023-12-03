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
        Schema::table('user_job_applications', function (Blueprint $table) {
            $table->mediumText('cancelled_notes')->nullable();
            $table->unsignedInteger('cancelled_by')->nullable();
            $table->dateTime('cancelled_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_job_applications', function (Blueprint $table) {
            $table->dropColumn('cancelled_notes');
            $table->dropColumn('cancelled_by');
            $table->dropColumn('cancelled_at');
        });
    }
};
