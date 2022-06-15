<?php

require "./vendor/autoload.php";

abstract class RefreshTokenFactory implements Factory {
    function createInstance(...$params):RefreshToken{
        return new RefreshToken(...$params);
    }
}