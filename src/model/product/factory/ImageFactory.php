<?php
require "./vendor/autoload.php";

abstract class ImageFactory implements Factory {
    function createInstance(...$params):Image
    {
        return new Image(...$params);
    }
}