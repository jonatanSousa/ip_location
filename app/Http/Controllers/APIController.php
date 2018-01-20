<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
Use geoIpCountry;

class APIController extends Controller
{
    public function getCountryByIp($requestedIp)
    {

        if(!config('Api.ApiStatus')){

            return response()->json()->setStatusCode(503, 'Maintenance, please return later');
        }

        $requestedIp = ip2long($requestedIp);
        if (filter_var( $requestedIp,  FILTER_VALIDATE_IP)) {
            return response()->json()->setStatusCode(400, 'please correct the ip address');
        }


        $country = DB::table('geo_ip_countries')
            ->where(
                [
                    ['min_int_ip', '<=', $requestedIp],
                    ['max_int_ip', '>=', $requestedIp],
                ]
            )->get();

        if (count($country) <= 0) {
            return response()->json()->setStatusCode(404, 'country not available.');
        }

        return json_encode($country[0]);
    }

}


