<?php
require "./vendor/autoload.php";
abstract class ProductSubscriberFactory implements Factory {
    function createInstance(...$params)
    {
        return new ProductSubscriber(...$params);
    }
}