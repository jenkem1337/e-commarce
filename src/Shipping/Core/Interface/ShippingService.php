<?php

interface ShippingService {
    function findAll(FindAllShippingMethodDto $dto):ResponseViewModel;
    function findOneByUuid(FindOneShippingMethodDto $dto): ResponseViewModel;
    function createShippingForOrderCreation(CreationalShippingDto $dto): ResponseViewModel;
    function setStateToDispatched(ShippingStatusDto $dto);
    function setStateToDelivered(ShippingStatusDto $dto):ResponseViewModel;
    function isShipmentDelivered(IsShippingDeliveredDto $dto);
    function setStateToCanceled(ShippingStatusDto $shippingStatusDto);
}