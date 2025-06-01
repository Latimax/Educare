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
        Schema::create('result_comments', function (Blueprint $table) {
            $table->id();
            $table->string('comment');
            //Comments belongs to a grade on grades table
            $table->foreignId('grade_id')
                ->constrained('grades')
                ->onDelete('cascade'); // Ensures that if a grade is deleted, its comments are also deleted
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_comments');
    }
};
