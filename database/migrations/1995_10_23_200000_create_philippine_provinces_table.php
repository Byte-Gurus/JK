<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePhilippineProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('philippine_provinces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('psgc_code')->index();
            $table->string('province_description');
            $table->string('region_code');
            $table->string('province_code')->unique();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');

            $table->foreign('region_code')->references('region_code')->on('philippine_regions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('philippine_provinces');
    }
}
