<?php

use GuzzleHttp\Client;

class APIControllerTest extends TestCase
{

    private $client;

    public function setup(){

        $this->client = new Client();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetCountryByIp_responseOk()
    {
        $response = $this->client->request('GET', 'http://geoip.dev/locationByIP/81.0.3.244');
        $this->assertEquals(200, $response->getStatusCode());
    }


    public function testGetCountryByIp_responseNotOk()
    {
        try {
            $response = $this->client->request('GET', 'http://geoip.dev/locationByIP/81.0.3.300');
            }
            catch (GuzzleHttp\Exception\ClientException $e) {
                $response = $e->getResponse();
            }

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testGetCountryByIp_confirmCountry()
    {
        //test country norway
        $response = $this->client->request('GET', 'http://geoip.dev/locationByIP/2.151.255.255');

        $body = json_decode($response->getBody());

        $this->assertEquals('Norway', $body->country_name);
    }




}
