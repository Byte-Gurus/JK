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
        Schema::create('transaction_movements', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_type');
            $table->timestamps();

            $table->foreignId('transaction_id')->nullable()->constrained('transactions');
            $table->foreignId('credit_id')->nullable()->constrained('credits');
            $table->foreignId('returns_id')->nullable()->constrained('returns');
            $table->foreignId('void_transaction_id')->nullable()->constrained('void_transactions');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_movements');
    }
};
