<?php

class ShippingController {
    private ShippingService $shippingService;
    function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    function findAllShippingMethods(){
        $this->shippingService->findAll(new FindAllShippingMethodDto)
                            ->onSucsess(function (AllShippingMethodsResponseDto $response){
                                echo json_encode($response);
                            })->onError(function (ErrorResponseDto $err){
                                echo json_encode($err);    
                                http_response_code($err->getErrorCode());        
                            });
    }

    function findOneShippingMethod($uuid){
        $this->shippingService->findOneByUuid(new FindOneShippingMethodDto($uuid))
                            ->onSucsess(function (OneShippingMethodFoundedResponseDto $response){
                                echo json_encode($response);
                            })->onError(function (ErrorResponseDto $err){
                                echo json_encode($err);    
                                http_response_code($err->getErrorCode());                                                                                
                            });
    }
}