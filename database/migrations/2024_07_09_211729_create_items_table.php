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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique();
            $table->string('item_name');
            $table->string('item_description');
            $table->double('maximum_stock_ratio');
            $table->double('reorder_percentage');
            $table->double('reorder_point');
            $table->string('vat_type');
            $table->double('vat_amount');
            $table->timestamps();


            $table->foreignId('status_id')->constrained('statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
