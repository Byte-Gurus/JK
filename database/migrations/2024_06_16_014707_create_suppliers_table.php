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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('contact_number');
            $table->string('street');
            $table->string('province_code');
            $table->string('city_municipality_code');
            $table->string('barangay_code');

            $table->foreignId('status_id')->constrained('statuses');

            $table->foreign('province_code')->references('province_code')->on('philippine_provinces');
            $table->foreign('city_municipality_code')->references('city_municipality_code')->on('philippine_cities');
            $table->foreign('barangay_code')->references('barangay_code')->on('philippine_barangays');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
