<?php

require "./vendor/autoload.php";

abstract class RateFactory implements Factory {
    function createInstance($isMustBeConcreteObject =false ,...$params): RateInterface
    {
        try {
            return new Rate(...$params);
        } catch (\Throwable $th) {
            return new NullRate();
        }
    }
}