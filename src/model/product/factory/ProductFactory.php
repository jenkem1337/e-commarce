<?php
require "./vendor/autoload.php";

abstract class ProductFactory implements Factory {
    function createInstance(...$params):Product
    {
        return new Product(...$params); 
    }
}