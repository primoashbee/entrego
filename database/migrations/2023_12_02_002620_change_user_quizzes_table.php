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
        Schema::table('user_quizzes', function (Blueprint $table) {
            $table->unsignedInteger('score')->nullable()->change();
            $table->boolean('is_passed')->nullable()->change();
            $table->unsignedInteger('checked_by')->nullable();
        });
        Schema::table('user_quiz_answers_v2', function (Blueprint $table) {
            $table->boolean('is_correct')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_quizzes', function (Blueprint $table) {
            $table->unsignedInteger('score')->nullable(false)->change();
            $table->boolean('is_passed')->nullable(false)->change();
            $table->dropColumn('checked_by');
        });
        Schema::table('user_quiz_answers_v2', function (Blueprint $table) {
            $table->boolean('is_correct')->nullable(false)->change();
        });

    }
};
