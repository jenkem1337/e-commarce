<?php

interface ShippingService {
    function findAll(FindAllShippingMethodDto $dto):ResponseViewModel;
    function findOneByUuid(FindOneShippingMethodDto $dto): ResponseViewModel;
    function createShippingForOrderCreation(CreationalShippingDto $dto): ResponseViewModel;
}