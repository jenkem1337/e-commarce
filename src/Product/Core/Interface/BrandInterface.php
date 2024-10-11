<?php
interface BrandInterface {
    function getName();
    function changeName($name);
    function addModel($uuid, $name, $createdAt, $updatedAt);
    function changeModelName($key, $value);
    public function getModelUuid($uuid);
    public function getUuid();

    public function getCreatedAt();

    public function getUpdatedAt();

    function isNull();

}