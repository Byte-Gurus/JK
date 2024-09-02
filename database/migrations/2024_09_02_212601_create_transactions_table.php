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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code')->unique();
            $table->string('transaction_type');
            $table->double('subtotal');
            $table->double('total_amount');
            $table->double('vat_amount');
            $table->timestamps();


            $table->foreignId('customer_id')->nullable()->constrained('items');
            $table->foreignId('user_id')->nullable()->constrained('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
