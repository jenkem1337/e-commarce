<?php

abstract class ShippingServiceDecorator implements ShippingService {
    private ShippingService $shippingService;
    function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }
    function findAll(FindAllShippingMethodDto $dto): ResponseViewModel
    {
        return $this->shippingService->findAll($dto);
    }
    function findOneByUuid(FindOneShippingMethodDto $dto): ResponseViewModel
    {
        return $this->shippingService->findOneByUuid($dto);
    }
    function createShippingForOrderCreation(CreationalShippingDto $dto): ResponseViewModel{
        return $this->shippingService->createShippingForOrderCreation($dto);
    }
    function setStateToDispatched(ShippingStatusDto $dto){
        return $this->shippingService->setStateToDispatched($dto);
    }
    function setStateToDelivered(ShippingStatusDto $dto):ResponseViewModel{
        return $this->shippingService->setStateToDelivered($dto);
    }
    function isShipmentDelivered(IsShippingDeliveredDto $dto){
        return $this->shippingService->isShipmentDelivered($dto);
    }
    function setStateToCanceled(ShippingStatusDto $shippingStatusDto){
        return $this->shippingService->setStateToCanceled($shippingStatusDto);
    }

}