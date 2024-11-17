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
        Schema::create('ceiling_prices', function (Blueprint $table) {
            $table->id();
            $table->double('ceiling_price');
            $table->timestamps();

            $table->foreignId('item_id')->constrained('items');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ceiling_prices');
    }
};
