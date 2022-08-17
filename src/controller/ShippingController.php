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
                                foreach($response->getShippings() as $shipping)
                                echo json_encode([
                                    'uuid'=>$shipping->getUuid(),
                                    'shipping_type' => $shipping->getShippingType(),
                                    'price' => $shipping->getPrice(),
                                    'created_at'=>$shipping->getCreatedAt(),
                                    'updated_at'=> $shipping->getUpdatedAt()
                                ]);
                            })->onError(function (ErrorResponseDto $err){
                                echo json_encode([
                                    'error_message'=>$err->getErrorMessage(),
                                    'status_code'=> $err->getErrorCode()
                                ]);
                    
                            });
    }

    function findOneShippingMethod($uuid){
        $this->shippingService->findOneByUuid(new FindOneShippingMethodDto($uuid))
                            ->onSucsess(function (OneShippingMethodFoundedResponseDto $response){
                                echo json_encode([
                                    'uuid'=>$response->getUuid(),
                                    'shipping_type' => $response->getType(),
                                    'price' => $response->getPrice(),
                                    'created_at'=>$response->getCreatedAt(),
                                    'updated_at'=> $response->getUpdatedAt()

                                ]);
                            })->onError(function (ErrorResponseDto $err){
                                echo json_encode([
                                    'error_message'=>$err->getErrorMessage(),
                                    'status_code'=> $err->getErrorCode()
                                ]);
                    
                            });
    }
}