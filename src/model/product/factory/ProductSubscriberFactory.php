<?php
require "./vendor/autoload.php";
abstract class ProductSubscriberFactory implements Factory {
    function createInstance($isMustBeConcreteObject =false,...$params)
    {
        return new ProductSubscriber(...$params);
    }
}