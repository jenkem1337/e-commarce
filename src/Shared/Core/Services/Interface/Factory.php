<?php

interface Factory{
    function createInstance($isMustBeConcreteObjcet = false, ...$params);
}