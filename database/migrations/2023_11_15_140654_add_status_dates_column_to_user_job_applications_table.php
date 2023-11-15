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
            $table->dateTime('job_offered_at')->nullable();
            $table->dateTime('job_offer_accepted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_job_applications', function (Blueprint $table) {
            $table->dropColumn('job_offered_at');
            $table->dropColumn('job_offer_accepted_at');
        });
    }
};
