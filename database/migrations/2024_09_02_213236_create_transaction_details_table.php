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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->integer('item_quantity');
            $table->string('vat_type');
            $table->double('item_subtotal');
            $table->double('item_discount_amount');
            $table->double('discount');
            $table->double('item_quantity');
            $table->timestamps();


            $table->foreignId('transaction_id')->constrained('transactions');
            $table->foreignId('item_id')->constrained('items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
