<?php
require "./vendor/autoload.php";
abstract class UserFactory implements Factory {
    function createInstance(...$params):UserInterface
    {
        try {
            //code...
            return new User(...$params);

        } catch (Exception $th) {
           return  new NullUser();
        }
    }
}