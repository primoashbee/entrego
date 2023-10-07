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
        Schema::create('user_personal_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('personal_question_id');
            $table->unsignedInteger('user_id');
            $table->string('answer');

            $table->string('extraversion_score');
            $table->string('extraversion_total');
            $table->string('extraversion_percentage');

            $table->string('agreeableness_score');
            $table->string('agreeableness_total');
            $table->string('agreeableness_percentage');

            $table->string('conscientiousness_score');
            $table->string('conscientiousness_total');
            $table->string('conscientiousness_percentage');

            $table->string('neuroticism_score');
            $table->string('neuroticism_total');
            $table->string('neuroticism_percentage');

            $table->string('openness_score');
            $table->string('openness_total');
            $table->string('openness_percentage');

            $table->string('batch_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_personal_assessments');
    }
};
