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
        Schema::create('void_transaction_details', function (Blueprint $table) {
            $table->id();
            $table->double('void_quantity');
            $table->double('item_void_amount');
            $table->string('reason');


            $table->foreignId('void_transaction_id')->constrained('void_transactions');
            $table->foreignId('transaction_details_id')->constrained('transaction_details');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('void_transaction_details');
    }
};
