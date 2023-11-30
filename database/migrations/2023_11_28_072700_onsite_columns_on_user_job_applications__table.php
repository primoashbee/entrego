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
        Schema::table('user_job_applications', function(Blueprint $table){
            $table->boolean('send_interview_onsite')->default(false);
            $table->boolean('job_offer_interview_onsite')->default(false);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_job_applications', function(Blueprint $table){
            $table->dropColumn('send_interview_onsite');
            $table->dropColumn('job_offer_interview_onsite');
        });
    }
};
