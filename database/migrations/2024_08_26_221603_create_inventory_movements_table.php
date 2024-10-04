t<?php

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
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->string('movement_type');
            $table->string('operation');
            $table->timestamps();

            $table->foreignId('inventory_id')->nullable()->constrained('inventories');
            $table->foreignId('inventory_adjustment_id')->nullable()->constrained('inventory_adjustments');
            $table->foreignId('transaction_detail_id')->nullable()->constrained('transaction_details');
            $table->foreignId('void_transaction_id')->nullable()->constrained('void_transactions');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
