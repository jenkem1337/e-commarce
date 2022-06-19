<?php
require "./vendor/autoload.php";

abstract class CategoryFactory implements Factory {
    function createInstance($isMustBeConcreteObject =false,...$params):CategoryInterface{
        if($isMustBeConcreteObject == true){
            return new Category(...$params);
        }
        try {
            //code...
            return new Category(...$params);

        } catch (\Exception $th) {
            //throw $th;
            return new NullCategory();

        }
    }
}