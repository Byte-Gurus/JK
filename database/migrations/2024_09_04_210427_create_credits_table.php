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
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('credit_number');
            $table->dateTime('due_date');
            $table->double('remaining_balance')->nullable();
            $table->double('credit_amount')->nullable();
            $table->double('credit_limit');
            $table->timestamps();

            $table->foreignId('transaction_id')->nullable()->constrained('transactions');
            $table->foreignId('customer_id')->constrained('customers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credits');
    }
};
