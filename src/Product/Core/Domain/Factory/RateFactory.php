<?php

abstract class RateFactory implements Factory {
    function createInstance($isMustBeConcreteObject =false ,...$params): RateInterface
    {
        if($isMustBeConcreteObject == true) {
            return new Rate(...$params);
        }
        try {
            return new Rate(...$params);
        } catch (\Exception $th) {
            return new NullRate();
        }
    }
}