<?php
require "./vendor/autoload.php";

abstract class ImageFactory implements Factory {
    function createInstance($isMustBeConcreteObject =false,...$params):ImageInterface
    {
        if($isMustBeConcreteObject == true){
            return new Image(...$params);
        }
        try {
            return new Image(...$params);
        } catch (\Exception $th) {
            return new NullImage();
        }
    }
}