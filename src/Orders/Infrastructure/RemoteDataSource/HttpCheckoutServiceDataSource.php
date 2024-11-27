<?php
use GuzzleHttp\Client;
class HttpCheckoutServiceDataSource implements RemoteCheckoutDataSource {
    private Client $checkoutReadClient;
    private Client $checkoutWriteClient;
    function __construct(){
        $this->checkoutReadClient = new Client([
            "base_uri" => $_ENV["CHECKOUT_READ_SERVICE_URI"]
        ]);
        $this->checkoutWriteClient = new Client([
            "base_uri" => $_ENV["CHECKOUT_WRITE_SERVICE_URI"]
        ]);
    }
    function findAmoundAndItemsByUuid($checkoutUuid, $jwtToken){
        $response = $this->checkoutReadClient->request("GET", "/api/v1/checkout/".$checkoutUuid, [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $jwtToken,
                        ]   
                    ]);
        return json_decode($response->getBody()->getContents());
    }

    function completeCheckout($checkoutUuid){
        $jwtToken = explode(' ', $_SERVER['HTTP_AUTHORIZATION'])[1];
            $this->checkoutWriteClient->request("POST", "/api/v1/checkout/complete/" . $checkoutUuid, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $jwtToken,
                ],
            ]);
    }
}