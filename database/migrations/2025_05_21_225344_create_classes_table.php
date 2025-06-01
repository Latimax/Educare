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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('class_name');

            // Section limited to values A, B, C, D, E using enum
            $table->enum('section', ['A', 'B', 'C', 'D', 'E'])->default('A');

            // Nullable foreign key to staff(teachers) table
            $table->foreignId('class_teacher_id')->nullable()->constrained('staffs')->onDelete('set null');

            // Status with enum, default active
            $table->enum('status', ['active', 'disabled'])->default('active');

            // Foreign key to levels table (required)
            $table->foreignId('level_id')->constrained('levels')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
