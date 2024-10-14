<?php
interface BrandInterface {
    function getName();
    function changeName($name);
    function addModel(ModelInterface $modelInterface);
    function createModel($name);
    function changeModelName($key, $value);
    function deleteModel($modelUuid);
    public function getModelUuid($uuid);
    public function getUuid();

    public function getCreatedAt();

    public function getUpdatedAt();

    function isNull();

}