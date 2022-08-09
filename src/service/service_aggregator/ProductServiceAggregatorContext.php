<?php
require './vendor/autoload.php';
class ProductServiceAggregatorContext implements ServiceAggregator{
    private array $services;
    function __construct(array $services)
    {
        $this->services = $services;
    }

    function getService($serviceInstanceName){
        $service = $this->services[$serviceInstanceName];
        if(!$service) throw new NotFoundException('service');
        return $service;
    }
}