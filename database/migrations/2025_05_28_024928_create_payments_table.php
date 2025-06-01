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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->decimal('amount_paid', 10, 2);
            $table->string('purpose');
            $table->decimal('balance', 10, 2)->default(0.00);
            $table->string('paid_by');
            $table->string('received_by');
            $table->date('payment_date');
            $table->string('payment_method');
            $table->enum('status', ['paid', 'pending', 'failed'])->default('paid');
            $table->text('notes')->nullable(); // Optional notes about the payment
            $table->string('receipt_number')->nullable(); // Optional receipt number
        //session and term information
            $table->string('session')->nullable(); // e.g., '2025/2026'
            $table->enum('term', ['first', 'second', 'third'])->nullable(); // e.g., 'first', 'second', 'third'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
