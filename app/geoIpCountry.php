<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class geoIpCountry extends Model
{
    protected $table = 'geo_ip_countries';
    public $timestamps = false;
}
