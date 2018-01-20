<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ZipArchive;
use App\geoIpCountry;
use Illuminate\Support\Facades\DB;


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
            $id= 1;
            $ipTable = new geoIpCountry ();
            while (($data = fgetcsv($handle, 1, ',')) !== FALSE) {
                $ipTable = new geoIpCountry ();

                $hasId = DB::table('geo_ip_countries')->where('id', $id)->first();
                $ipTable->id = '';
                $ipTable->min_ip_range = $data [0];
                $ipTable->max_ip_range = $data [1];
                $ipTable->min_int_ip = $data [2];
                $ipTable->max_int_ip = $data [3];
                $ipTable->country_code = $data [4];
                $ipTable->country_name = $data [5];
                $ipTable->created_at = date("Y-m-d H:i:s");
                $ipTable->updated_at = date("Y-m-d H:i:s");

                if(isset( $hasId->id )){
                    $ipTable->id = $hasId->id ?? '';

                    $ipTable::where('id', '=', $id)->update([
                            'min_ip_range' => $data [0],
                            'max_ip_range' => $data [1],
                            'min_int_ip' => $data [2],
                            'max_int_ip' => $data [3],
                            'country_code' => $data [4],
                            'country_name' => $data [5],
                            'updated_at' => date("Y-m-d H:i:s")
                        ]);
                    print_r(  $hasId->id  .' updating  '.$data [5]."\n");
                    $id++;
                    continue;
                }


                $ipTable->save();
                $id++;

                print_r($id.' creating  '.$data [5]."\n");
            }
            fclose($handle);
        }
    }
}
