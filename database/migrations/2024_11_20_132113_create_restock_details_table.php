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
        Schema::create('restock_details', function (Blueprint $table) {
            $table->id();
            $table->double("cost");
            $table->integer("restock_quantity");
            $table->datetime('expiration_date')->nullable();
            $table->string('sku_code')->unique();
            $table->integer("bacorder_quantity");
            $table->timestamps();

            $table->foreignId('item_id')->constrained('items');
            $table->foreignId('delivery_id')->constrained('deliveries');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restock_details');
    }
};
