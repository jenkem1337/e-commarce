<?php

class ShippingFactoryContext {
    private $shippingFactories;
    function __construct($shippingFactories)
    {
        $this->shippingFactories = $shippingFactories;
    }
    function executeFactory($key, $isMustBeConcreteObjcet, ...$params): ShippingInterface{
        try{
            $factoryInstance = $this->shippingFactories[$key];
            if(!$factoryInstance) throw new NotFoundException('factory instance');
            return $factoryInstance->createInstance($isMustBeConcreteObjcet, ...$params);
    
        }catch(Exception $err){
            return new NullShipping;
        }
    }
}