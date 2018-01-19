<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeoIpContriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geo_ip_countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('min_ip_range');
            $table->string('max_ip_range');
            $table->bigInteger('min_number_ip');
            $table->bigInteger('max_number_ip');
            $table->string('country_code', 2);
            $table->string('country_name', 60);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('geo_ip_countries');
    }
}
