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
        Schema::create('student_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');

            $table->unsignedBigInteger('class_id');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');

            $table->string('session');
            $table->string('term');
            $table->json('resultData')->nullable();
            $table->integer('total_time_present')->nullable();

            //Average field as decimal
            $table->decimal('average', 5, 2)->nullable();

            //Position field
            $table->string('position')->nullable();

            // Behavioral/Skill scores
            //Array of 'excellent', 'good', 'fair', 'poor', 'v_poor
            $table->enum('handwriting', ['excellent', 'good', 'fair', 'poor', 'v_poor'])->nullable();
            $table->enum('verbal', ['excellent', 'good', 'fair', 'poor', 'v_poor'])->nullable();
            $table->enum('sports', ['excellent', 'good', 'fair', 'poor', 'v_poor'])->nullable();
            $table->enum('drawing', ['excellent', 'good', 'fair', 'poor', 'v_poor'])->nullable();
            $table->enum('craftwork', ['excellent', 'good', 'fair', 'poor', 'v_poor'])->nullable();
            $table->enum('punctuality', ['excellent', 'good', 'fair', 'poor', 'v_poor'])->nullable();
            $table->enum('regularity', ['excellent', 'good', 'fair', 'poor', 'v_poor'])->nullable();
            $table->enum('neatness', ['excellent', 'good', 'fair', 'poor', 'v_poor'])->nullable();
            $table->enum('politeness', ['excellent', 'good', 'fair', 'poor', 'v_poor'])->nullable();
            $table->enum('honesty', ['excellent', 'good', 'fair', 'poor', 'v_poor'])->nullable();
            $table->enum('cooperation', ['excellent', 'good', 'fair', 'poor', 'v_poor'])->nullable();
            $table->enum('emotional', ['excellent', 'good', 'fair', 'poor', 'v_poor'])->nullable();
            $table->enum('health', ['excellent', 'good', 'fair', 'poor', 'v_poor'])->nullable();
            $table->enum('behaviour', ['excellent', 'good', 'fair', 'poor', 'v_poor'])->nullable();
            $table->enum('attentiveness', ['excellent', 'good', 'fair', 'poor', 'v_poor'])->nullable();


            // Comments and additional data
            $table->text('class_teacher_comment')->nullable();
            $table->text('principal_comment')->nullable();
            $table->string('conduct')->nullable();
            $table->tinyInteger('noofsubjectpass')->nullable();

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_results');
    }
};
