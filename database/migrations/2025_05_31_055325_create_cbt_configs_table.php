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
        Schema::create('cbt_configs', function (Blueprint $table) {
            $table->id();
            //Enable/Disable First Test, Second Test, and Exam status
            $table->boolean('ft_status')->default(true)->comment('First Test Status');
            $table->boolean('st_status')->default(true)->comment('Second Test Status');
            $table->boolean('exam_status')->default(true)->comment('Exam Status');
            $table->integer('total_time')->default(20)->comment('Total time for the test in mins');
            $table->integer('attempts_allowed')->default(1)->comment('Number of attempts allowed');
            $table->boolean('shuffle_questions')->default(true)->comment('Shuffle questions');
            $table->boolean('shuffle_answers')->default(true)->comment('Shuffle answers');
            $table->boolean('show_correct_answers')->default(true)->comment('Show correct answers after test');

            //first test, second test, and exam total questions
            $table->integer('ft_total_questions')->default(10)->comment('Total questions for First Test');
            $table->integer('st_total_questions')->default(10)->comment('Total questions for Second Test');
            $table->integer('exam_total_questions')->default(20)->comment('Total questions for Exam');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cbt_configs');
    }
};
