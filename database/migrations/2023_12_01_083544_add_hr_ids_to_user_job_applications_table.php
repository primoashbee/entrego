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
            $table->unsignedInteger("interviewed_by")->nullable();
            $table->unsignedInteger("deployed_by")->nullable();
            $table->unsignedInteger("job_offer_sent_by")->nullable();
            $table->unsignedInteger("job_offer_accepted_by")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_job_applications', function (Blueprint $table) {
            $table->dropColumn("interviewed_by");
            $table->dropColumn("deployed_by");
            $table->dropColumn("job_offer_sent_by");
            $table->dropColumn("job_offer_accepted_by");
        });
    }
};
