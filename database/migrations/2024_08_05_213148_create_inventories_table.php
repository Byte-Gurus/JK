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
            $table->string('sku_code')->unique()->nullable();
            $table->double('cost')->default(0);
            $table->double('mark_up_price')->default(0);
            $table->double('selling_price')->default(0);
            $table->integer('current_stock_quantity')->default(0);
            $table->datetime('expiration_date')->nullable();
            $table->datetime('stock_in_date')->nullable();
            $table->string('status')->default('New Item');
            $table->timestamps();



            $table->foreignId('item_id')->nullable()->constrained('items');
            $table->foreignId('delivery_id')->nullable()->constrained('deliveries');
            $table->foreignId('user_id')->nullable()->constrained('users');
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
