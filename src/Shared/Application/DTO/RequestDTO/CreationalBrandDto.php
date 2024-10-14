<?php

class CreationalBrandDto {
    private $name;
    function __construct($name) {
        $this->name = $name;
    }

    function name() {return $this->name;}
}