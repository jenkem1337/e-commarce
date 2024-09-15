<?php
abstract class ProductSubscriberFactory implements Factory {
    function createInstance($isMustBeConcreteObject =false,...$params): ProductSubscriberInterface
    {
        if($isMustBeConcreteObject == true){
            return new ProductSubscriber(...$params);
        }
        try {
            //code...
            return new ProductSubscriber(...$params);
        } catch (\Exception $th) {
            //throw $th;
            return new NullProductSubscriber();
        }
        
    }
}