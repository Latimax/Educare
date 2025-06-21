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
        Schema::create('graduated_students', function (Blueprint $table) {
            $table->id();
            $table->string('studentId')->unique(); // Custom student ID
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->date('dob');
            $table->text('address');
            $table->string('state');
            $table->string('country');
            $table->unsignedBigInteger('class_id');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('parents')->onDelete('set null');
            $table->enum('gender', ['male', 'female']);
            $table->string('photo')->nullable(); // URL or file path
            $table->string('blood_group')->nullable(); // Optional for medical info
            $table->string('previous_school')->nullable();
            $table->date('admission_date');
            $table->string('admission_number')->unique();
            $table->enum('status', ['active', 'disabled','graduated', 'dismissed'])->default('active');
            $table->string('role')->default('student'); // For role-based access if needed
            $table->enum('religion', ['muslim', 'christian'])->nullable();
            $table->string('password'); // Password should be hashed
            $table->string('session')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graduated_students');
    }
};
