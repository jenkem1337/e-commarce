<?php
require "./vendor/autoload.php";

abstract class CategoryFactory implements Factory {
    function createInstance($isMustBeConcreteObject =false,...$params):Category{
        return new Category(...$params);
    }
}