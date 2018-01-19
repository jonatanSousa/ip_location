<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ZipArchive;
use App\geoIpContry;
use Illuminate\Support\Facades\DB;

class CountryIpController extends Controller
{
    private $url = 'http://geolite.maxmind.com/download/geoip/database/GeoIPCountryCSV.zip' ;

    public function index()
    {

        !file_exists('tmp/GeoIPCountryWhois.csv') ? $this->DownloadAndSaveZipFile() : '';

        $requestedIp = '1.1.128.3';

        $country = $this->getCountryByIp($requestedIp);

        print_r(json_encode($country));

    }

    private function DownloadAndSaveZipFile()
    {
        $content = file_get_contents($this->url);
        file_put_contents('tmp.zip', $content);

        $zip = new ZipArchive;
        if ($zip->open("tmp.zip") === TRUE) {
            $zip->extractTo('tmp');
            $zip->close();
            //echo 'ok';
        } else {
            //echo 'failed';
        }

        if (($handle = fopen('tmp/GeoIPCountryWhois.csv', 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $csv_data = new geoIpContry ();
                $csv_data->id = '';
                $csv_data->min_ip_range = $data [0];
                $csv_data->max_ip_range = $data [1];
                $csv_data->min_int_ip = $data [2];
                $csv_data->max_int_ip = $data [3];
                $csv_data->country_code = $data [4];
                $csv_data->country_name = $data [5];
                $csv_data->save();
            }
            fclose($handle);
        }
    }


    private function getCountryByIp($requestedIp)
    {
        $requestedIp = ip2long($requestedIp);

        $country = DB::table('geo_ip_countries')
            ->where(
                [
                    ['min_int_ip', '<=', $requestedIp],
                    ['max_int_ip', '>=', $requestedIp],
                ]
            )->get();

        return $country;
    }

}


