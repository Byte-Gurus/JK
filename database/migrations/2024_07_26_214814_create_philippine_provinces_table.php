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
        Schema::create('philippine_provinces', function (Blueprint $table) {
            $table->id('id');
            $table->string('psgc_code')->index();
            $table->string('province_description');
            $table->string('region_code')->index();
            $table->string('province_code')->unique();
            $table->timestamps();

            $table->foreign('region_code')->references('region_code')->on('philippine_regions');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('philippine_provinces');
    }
};
