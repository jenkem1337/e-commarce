<?php
interface ImageInterface {
    public function getProductUuid();
    public function getLocation();
    public function getImageName();

    public function getUuid();

    public function getCreatedAt();

    public function getUpdatedAt();

    function isNull();

}