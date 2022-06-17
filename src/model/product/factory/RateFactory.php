<?php

require "./vendor/autoload.php";

abstract class RateFactory implements Factory {
    function createInstance(...$params): RateInterface
    {
        try {
            return new Rate(...$params);
        } catch (\Throwable $th) {
            return new NullRate();
        }
    }
}