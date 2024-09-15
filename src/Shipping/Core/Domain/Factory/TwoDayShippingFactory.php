<?php

abstract class TwoDayShippingFactory implements Factory {
    function createInstance($isMustBeConcreteObjcet = false, ...$params)
    {
        if($isMustBeConcreteObjcet){
            return new Shipping(...$params);
        }
        try {
            return new Shipping(...$params);
        } catch (\Exception $th) {
            //throw $th;
            return new NullShipping;
        }
    }
}