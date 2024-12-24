<?php

class NullBrand implements BrandInterface, NullEntityInterface {
    function getModels(): ModelCollection{return new ModelCollection();}
    function getName(){}
    function changeName($name){}
    function addModel(ModelInterface $modelInterface) {}
    function deleteModel($modelUuid){}
    function createModel($name) {}
    function changeModelName($key, $value){}
    public function getUuid(){}

    public function getCreatedAt(){}

    public function getUpdatedAt(){}
    function getModelUuid($uuid)
    {
        
    }

    function isNull():bool{
        return true;
    }


}