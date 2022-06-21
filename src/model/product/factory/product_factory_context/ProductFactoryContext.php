<?php

class ProductFactoryContext {
    private array $factoryMap;

    function __construct(array $arr)
    {
        $this->factoryMap = $arr;
    }

    function executeFactory($key, $isMustBeConcreteObjcet = false, ...$params):ProductInteface{
        $concreteProductFactory = $this->factoryMap[$key];
        if(!$concreteProductFactory) throw new DoesNotExistException('concrete factory');
        $product =  $concreteProductFactory->createInstance($isMustBeConcreteObjcet, ...$params);
        if(!($product instanceof ProductInteface)) throw new Error('product not instance of ProductInterface');
        return $product;
    }
}