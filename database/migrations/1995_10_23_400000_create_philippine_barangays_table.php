<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePhilippineBarangaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('philippine_barangays', function (Blueprint $table) {
            $table->increments('id');
            $table->string('barangay_code')->unique();
            $table->string('barangay_description');
            $table->string('region_code');
            $table->string('province_code');
            $table->string('city_municipality_code');
            $table->timestamps();


            $table->foreign('region_code')->references('region_code')->on('philippine_regions');
            $table->foreign('province_code')->references('province_code')->on('philippine_provinces');
            $table->foreign('city_municipality_code')->references('city_municipality_code')->on('philippine_cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('philippine_barangays');
    }
}
