<?php
require "./vendor/autoload.php";
abstract class UserFactory implements Factory {
    function createInstance($isMustBeConcreteObject = false, ...$params):UserInterface
    {
        if($isMustBeConcreteObject == true){
            return new User(...$params);
        }

        try {
            return new User(...$params);
        } catch (Exception $th) {
           return  new NullUser();
        }
    }
}