<?php
require "./vendor/autoload.php";

abstract class ProductFactory implements Factory {
    function createInstance($isMustBeConcreteObject =false,...$params):Product
    {
        return new Product(...$params); 
    }
}