<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ZipArchive;
use App\geoIpContry;


class updateGeoIpTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:populateGeoIpDB';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = 'http://geolite.maxmind.com/download/geoip/database/GeoIPCountryCSV.zip';

        $content = file_get_contents($url);
        file_put_contents('tmp.zip', $content);

        $zip = new ZipArchive;
        if ($zip->open("tmp.zip") === TRUE) {
            $zip->extractTo('tmp');
            $zip->close();
            echo 'success File unziped';
        } else {
            return 'it was not possible to unzip the file';
        }

        if (($handle = fopen('tmp/GeoIPCountryWhois.csv', 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $csv_ip = new geoIpContry ();
                $csv_ip->id = '';
                $csv_ip->min_ip_range = $data [0];
                $csv_ip->max_ip_range = $data [1];
                $csv_ip->min_int_ip = $data [2];
                $csv_ip->max_int_ip = $data [3];
                $csv_ip->country_code = $data [4];
                $csv_ip->country_name = $data [5];
                $csv_ip->created_at = date("Y-m-d H:i:s");
                $csv_ip->updated_at = date("Y-m-d H:i:s");
                $csv_ip->save();
                print_r(' updating  '.$data [5]."\n");
            }
            fclose($handle);
        }

    }
}
