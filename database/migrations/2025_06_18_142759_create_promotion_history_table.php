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
        Schema::create('promotion_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('previous_class_id');
            $table->unsignedBigInteger('current_class_id');
            $table->date('promotion_date');
            $table->timestamps();

            // Foreign key constraints (optional, remove if you don't want them)
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('previous_class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('current_class_id')->references('id')->on('classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_history');
    }
};
