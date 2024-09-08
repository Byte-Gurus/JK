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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string("firstname");
            $table->string("middlename");
            $table->string("lastname");
            $table->string("birthdate");
            $table->string('contact_number');
            $table->string("customer_type");
            $table->string("customer_discount_no");
            $table->string("id_picture");

            $table->foreignId('address_id')->constrained('addresses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
