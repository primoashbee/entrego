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
        Schema::create('man_powers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("requested_by");
            $table->string('job_title');
            $table->string('job_group');
            $table->text('description');
            $table->text('responsibilities');
            $table->text('qualifications');
            $table->text('benefits');
            $table->unsignedInteger('vacancies');
            $table->string('job_nature');
            $table->string('location');
            $table->date('expires_at');
            $table->string('required_experience');
            $table->string('department');
            $table->boolean('active')->default(false);
            $table->boolean('approved_by')->nullable();
            $table->dateTime('approved_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('man_powers');
    }
};
