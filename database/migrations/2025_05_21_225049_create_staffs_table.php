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
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->string('staffId')->unique();
            $table->string('fullname');
            $table->string('password');
            $table->string('email')->unique()->nullable();
            $table->enum('status', ['active', 'disabled'])->default('active');
            $table->string('user_type')->default('staff');
            $table->string('phone')->nullable();
            $table->date('dob')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->default('Nigeria');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('highest_qualification')->nullable();
            $table->string('position')->nullable();
            $table->string('photo')->nullable(); // path to photo
            $table->string('department')->nullable();
            $table->date('employment_date')->nullable();
            $table->string('subject_specialty')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staffs');
    }
};
