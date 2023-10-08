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
        Schema::create('user_job_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('man_power_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('rejected_by')->nullable();
            $table->unsignedInteger('accepted_by')->nullable();
            $table->string('status'); //Applied, Accepted, Interview Sent, Rejected, Accepted
            $table->dateTime('applied_at');
            $table->dateTime('interview_sent_at')->nullable(); 
            $table->dateTime('rejected_at')->nullable(); 
            $table->dateTime('accepted_at')->nullable(); 
            $table->text('rejected_reason')->nullable();
            $table->text('accepted_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_job_applications');
    }
};
