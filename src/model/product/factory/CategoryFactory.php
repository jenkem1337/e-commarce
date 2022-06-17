<?php
require "./vendor/autoload.php";

abstract class CategoryFactory implements Factory {
    function createInstance(...$params):Category{
        return new Category(...$params);
    }
}