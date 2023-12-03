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
        Schema::table('man_powers', function (Blueprint $table) {
            $table->string('job_group')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('null_on_man_powers', function (Blueprint $table) {
            $table->string('job_group')->nullable(false)->change();

        });
    }
};
