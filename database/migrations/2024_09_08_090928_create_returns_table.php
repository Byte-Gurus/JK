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
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->string('return_number')->unique();
            $table->double('return_total_amount');
            $table->double('original_amount');
            $table->double('refund_amount');
            $table->double('exchange_amount');
            $table->double('return_vat_amount');
            $table->boolean('hasTransaction');
            $table->string('returnedBy');
            $table->string('approvedBy');
            $table->timestamps();

            $table->foreignId('transaction_id')->constrained('transactions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
