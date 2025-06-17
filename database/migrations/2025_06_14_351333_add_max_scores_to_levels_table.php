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
        Schema::table('levels', function (Blueprint $table) {
           $table->integer('ft_max_score')->default(20)->after('status');
            $table->integer('st_max_score')->default(20)->after('ft_max_score');
            $table->integer('exam_max_score')->default(60)->after('st_max_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('levels', function (Blueprint $table) {
            $table->dropColumn(['ft_max_score', 'st_max_score', 'exam_max_score']);
        });
    }
};
