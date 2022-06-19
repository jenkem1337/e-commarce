<?php
require "./vendor/autoload.php";

abstract class ProductFactory implements Factory {
    function createInstance($isMustBeConcreteObject =false,...$params):ProductInteface
    {
        if($isMustBeConcreteObject == true){
            return new Product(...$params); 
        }
        try {
            //code...
            return new Product(...$params); 
        } catch (\Exception $th) {
            //throw $th;
            return new NullProduct();
        }
    }
}