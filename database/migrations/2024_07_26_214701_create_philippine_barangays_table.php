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
        Schema::create('philippine_barangays', function (Blueprint $table) {
            $table->id('id');
            $table->string('barangay_code')->unique();
            $table->string('barangay_description');
            $table->string('region_code')->index();
            $table->string('province_code')->index();
            $table->string('city_municipality_code')->index();
            $table->timestamps();


            $table->foreign('region_code')->references('region_code')->on('philippine_regions');
            $table->foreign('province_code')->references('province_code')->on('philippine_provinces');
            $table->foreign('city_municipality_code')->references('city_municipality_code')->on('philippine_cities');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('philippine_barangays');
    }
};
