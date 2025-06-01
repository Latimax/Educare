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
           $table->integer('ft_min_score')->default(2)->after('status');
            $table->integer('st_min_score')->default(2)->after('ft_min_score');
            $table->integer('exam_min_score')->default(10)->after('st_min_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('levels', function (Blueprint $table) {
            $table->dropColumn(['ft_min_score', 'st_min_score', 'exam_min_score']);
        });
    }
};
