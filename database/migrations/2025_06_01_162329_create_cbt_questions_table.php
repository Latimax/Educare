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
        Schema::create('cbt_questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
             $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('classes_id');

            $table->text('question'); // The question text
            $table->text('option_a'); // JSON or text field for options
            $table->text('option_b'); // JSON or text field for options
            $table->text('option_c'); // JSON or text field for options
            $table->text('option_d'); // JSON or text field for options

            //answer filed
            $table->string('answer'); // The correct answer (e.g., 'A', 'B', 'C', 'D')
            $table->enum('status', ['active', 'disabled'])->default('active'); // Status of the question

             // Optional: Add foreign keys if related tables exist
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('classes_id')->references('id')->on('classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cbt_questions');
    }
};
