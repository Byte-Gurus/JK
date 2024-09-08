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
        Schema::create('return_details', function (Blueprint $table) {
            $table->id();
            $table->integer('return_quantity');
            $table->double('item_return_amount');
            $table->string('description');
            $table->timestamps();

            $table->foreignId('return_id')->constrained('returns');

            $table->foreignId('transaction_details_id')->constrained('transaction_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_details');
    }
};
