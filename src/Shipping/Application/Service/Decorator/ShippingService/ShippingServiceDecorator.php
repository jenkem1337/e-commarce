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
}