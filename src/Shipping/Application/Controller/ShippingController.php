<?php

class ShippingController {
    private ShippingService $shippingService;
    function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    function findAllShippingMethods(){
        $response = $this->shippingService->findAll(new FindAllShippingMethodDto);
        http_response_code(200);
        echo json_encode($response);    

    }

    function findOneShippingMethod($uuid){
        $response = $this->shippingService->findOneByUuid(new FindOneShippingMethodDto($uuid));
        http_response_code(response_code: 200);
        echo json_encode($response);    

    }

    function shippingDelivered($shippingUuid) {
        $response = $this->shippingService->setStateToDelivered(new ShippingStatusDto($shippingUuid));
        http_response_code(response_code: 200);
        echo json_encode($response);    

    }
}