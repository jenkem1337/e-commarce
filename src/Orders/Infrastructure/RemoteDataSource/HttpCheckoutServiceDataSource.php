<?php
use GuzzleHttp\Client;
class HttpCheckoutServiceDataSource implements RemoteCheckoutDataSource {
    private Client $client;
    function __construct(){
        $this->client = new Client([
            "base_uri" => $_ENV["CHECKOUT_READ_SERVICE_URI"]
        ]);
    }
    function findAmoundAndItemsByUuid($checkoutUuid, $jwtToken){
        $response = $this->client->request("GET", "/api/v1/checkout/".$checkoutUuid, [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $jwtToken,
                        ]   
                    ]);
        return json_decode($response->getBody()->getContents());
    }
}