<?php

abstract class SameDayShippingFactory implements Factory {
    function createInstance($isMustBeConcreteObjcet = false, ...$params)
    {
        if($isMustBeConcreteObjcet){
            return new Shipping(...$params);
        }
        try {
            return new Shipping(...$params);

        } catch (\Exception $th) {
            return new NullShipping;
        }
    }
}