<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
Use geoIpCountry;

class APIController extends Controller
{
    public function getCountryByIp($requestedIp)
    {
        $requestedIp = ip2long($requestedIp);

        $country = DB::table('geo_ip_countries')
            ->where(
                [
                    ['min_int_ip', '<=', $requestedIp],
                    ['max_int_ip', '>=', $requestedIp],
                ]
            )->get();

        if (count($country) <= 0) {
            return response()->json()->setStatusCode(404, 'Not available.');
        }

        return json_encode($country[0]);
    }

}


