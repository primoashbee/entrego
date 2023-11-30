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
        Schema::table('man_powers', function(Blueprint $table){
            $table->boolean('has_sjt')->default(false);
            $table->boolean('quiz_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('man_powers', function(Blueprint $table){
            $table->dropColumn('has_sjt');
            $table->boolean('quiz_id')->nullable(false)->change();

        });
    }
};
