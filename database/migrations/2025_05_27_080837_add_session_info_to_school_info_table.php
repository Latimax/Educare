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
        Schema::table('school_info', function (Blueprint $table) {
            $table->string('current_session')->nullable();
            $table->enum('current_term', ['first', 'second', 'third'])->nullable();
            $table->date('session_start_date')->nullable();
            $table->date('session_end_date')->nullable();
            $table->integer('school_opened')->default(0)->nullable();
            $table->date('next_term_begin_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_info', function (Blueprint $table) {
            $table->dropColumn([
            'current_session',
            'current_term',
            'session_start_date',
            'session_end_date',
            'school_opened',
            'next_term_begin_date',
        ]);
        });
    }
};
