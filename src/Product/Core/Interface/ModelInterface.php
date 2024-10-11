<?php
interface ModelInterface {
    function getName();
    function changeName($newName);
    function getBrandUuid();
    public function getUuid();

    public function getCreatedAt();

    public function getUpdatedAt();

    function isNull();
}