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
        Schema::create('transaction_movements', function (Blueprint $table) {
            $table->id();
            $table->string('movement_type');
            $table->timestamps();

            $table->foreignId('transaction_id')->constrained('transaction');
            $table->foreignId('credit_id')->constrained('credits');
            $table->foreignId('returns_id')->constrained('returns');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_movements');
    }
};
