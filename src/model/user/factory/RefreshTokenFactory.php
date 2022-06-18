<?php

require "./vendor/autoload.php";

abstract class RefreshTokenFactory implements Factory {
    function createInstance($isMustBeConcreteObject =false,...$params):RefreshTokenInterface{
        if($isMustBeConcreteObject == true){
            return new RefreshToken(...$params);
        }

        try{
            return new RefreshToken(...$params);
        }catch(Exception $e) {
            return new NullRefreshToken();
        }
    }   
}