<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('void_transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('void_number')->unique();
            $table->double('void_total_amount');
            $table->double('original_amount');
            $table->double('void_vat_amount');
            $table->boolean('hasTransaction');
            $table->string('voidedBy');
            $table->string('approvedBy');



            $table->foreignId('transaction_id')->constrained('transactions');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('void_transactions');
    }
};
