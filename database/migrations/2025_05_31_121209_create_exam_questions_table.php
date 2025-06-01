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
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('classes_id');
            $table->text('contents');
            $table->enum('status', ['active', 'disabled'])->default('active');
            $table->string('session');  // E.g., 2024-2025
            $table->string('term');     // E.g., First Term
            $table->json('attachments')->nullable(); // for files, images, etc.
            $table->timestamps();

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
        Schema::dropIfExists('exam_questions');
    }
};
