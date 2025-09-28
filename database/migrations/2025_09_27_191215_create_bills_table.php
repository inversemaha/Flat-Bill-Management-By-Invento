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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flat_id')->constrained()->onDelete('cascade');
            $table->foreignId('bill_category_id')->constrained()->onDelete('cascade');
            $table->string('month'); // Format: 2024-01 for January 2024
            $table->year('year');
            $table->decimal('amount', 10, 2);
            $table->decimal('due_amount', 10, 2)->default(0); // Accumulated due from previous bills
            $table->decimal('total_amount', 10, 2); // amount + due_amount
            $table->enum('status', ['paid', 'unpaid', 'partially_paid'])->default('unpaid');
            $table->date('due_date');
            $table->date('paid_date')->nullable();
            $table->text('notes')->nullable();
            $table->text('payment_details')->nullable(); // JSON or text for payment info
            $table->timestamps();

            $table->index(['flat_id', 'month', 'year']);
            $table->index(['status', 'due_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
