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
        Schema::create('credit_histories', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->double('remaining_balance')->nullable();
            $table->double('credit_amount')->nullable();
            $table->timestamps();

            $table->foreignId('credit_id')->constrained('credits');
            $table->foreignId('payment_id')->nullable()->constrained('payments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_histories');
    }
};
