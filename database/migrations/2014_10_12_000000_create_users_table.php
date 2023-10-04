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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('gender')->nullable();
            $table->date('birthday')->nullable();
            $table->text('street')->nullable();
            $table->text('landmark')->nullable();
            $table->text('city')->nullable();
            $table->text('zip_code')->nullable();
            $table->text('country')->nullable();
            $table->string('role');
            $table->boolean('has_finished_profile')->default(false);
            
            $table->string('password');
            $table->text('skills')->nullable();
            $table->text('languages')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
