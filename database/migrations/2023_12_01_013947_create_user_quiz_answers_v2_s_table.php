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
        Schema::create('user_quiz_answers_v2', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_quiz_id');
            $table->unsignedInteger('quiz_questions_v2_id');
            $table->json('question_data');
            $table->string('question');
            $table->string('answer')->nullable();
            $table->boolean('is_correct');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_quiz_answers_v2');
    }
};
