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
            $table->mediumText('send_interview_notes')->nullable();
            $table->mediumText('approved_notes')->nullable();
            $table->mediumText('rejected_notes')->nullable();
            $table->mediumText('job_offer_notes')->nullable();
            $table->mediumText('accepted_job_offer_notes')->nullable();
            $table->mediumText('deployed_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_job_applications', function (Blueprint $table) {
            $table->dropColumn('send_interview_notes');
            $table->dropColumn('approved_notes');
            $table->dropColumn('rejected_notes');
            $table->dropColumn('job_offer_notes');
            $table->dropColumn('accepted_job_offer_notes');
            $table->dropColumn('deployed_notes');
        });
    }
};
