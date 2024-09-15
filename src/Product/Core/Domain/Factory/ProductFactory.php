<?php

abstract class ProductFactory implements Factory {
    function createInstance($isMustBeConcreteObject =false,...$params):ProductInterface
    {
        if($isMustBeConcreteObject == true){
            return new ProductConstructorRuleRequiredDecorator(...$params); 
        }
        try {
            //code...
            return new ProductConstructorRuleRequiredDecorator(...$params); 
        } catch (\Exception $th) {
            //throw $th;
            return new NullProduct();
        }
    }
}