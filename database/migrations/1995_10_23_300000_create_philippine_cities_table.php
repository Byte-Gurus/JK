<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class CreatePhilippineCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('philippine_cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('psgc_code')->index();
            $table->string('city_municipality_description');
            $table->string('region_code');
            $table->string('province_code');
            $table->string('city_municipality_code')->unique();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');

            $table->foreign('region_code')->references('region_code')->on('philippine_regions');
            $table->foreign('province_code')->references('province_code')->on('philippine_provinces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('philippine_cities');
    }
}
