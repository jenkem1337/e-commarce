<?php

require "./vendor/autoload.php";

abstract class RefreshTokenFactory implements Factory {
    function createInstance(...$params):RefreshTokenInterface{
        try{
            return new RefreshToken(...$params);
        }catch(Exception $e) {
            return new NullRefreshToken();
        }
    }   
}