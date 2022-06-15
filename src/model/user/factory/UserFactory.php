<?php
require "./vendor/autoload.php";
abstract class UserFactory implements Factory {
    function createInstance(...$params):User
    {
        return new User(...$params);
    }
}