<?php
class DeleteBrandDto {
    private $uuid;
    function __construct($uuid) {
        $this->uuid = $uuid;
    }

    function uuid(){return $this->uuid;}

}