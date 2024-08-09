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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('sku_code')->unique();
            $table->double('cost');
            $table->double('mark_up_price');
            $table->double('selling_price');
            $table->integer('current_stock_quantity');
            $table->datetime('expiration_date');
            $table->datetime('stock_in_date');
            $table->string('status');
            $table->timestamps();


            $table->foreignId('item_id')->constrained('items');
            $table->foreignId('supplier_id')->constrained('suppliers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
