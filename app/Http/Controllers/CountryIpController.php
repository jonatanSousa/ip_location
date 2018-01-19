<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ZipArchive;

class CountryIpController extends Controller
{
    private $url = 'http://geolite.maxmind.com/download/geoip/database/GeoIPCountryCSV.zip' ;
    public function index()
    {
        $contents = file_get_contents($this->url);

        $zip = new ZipArchive();
        $zip->open($contents);
        $zip->extractTo('./');
        echo "Ok!";
    }


}


