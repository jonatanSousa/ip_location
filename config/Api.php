<?php

//  GeoIP API config

return [
    //bollean to show maintanance in  API endpoint '1' shows results '0' gives an
    'ApiStatus' => env('API_STATUS', 1),

    //URL to csv to populate database
    'file_url' => env('GEOIP_FILE_URL', 'http://geolite.maxmind.com/download/geoip/database/GeoIPCountryCSV.zip')

];

