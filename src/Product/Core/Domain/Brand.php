<?php

class Brand extends BaseEntity implements AggregateRoot, BrandInterface {
    private $name;
    private ModelCollection $models;
    function __construct($uuid, $name, $createdAt, $updatedAt) {
        parent::__construct($uuid, $createdAt, $updatedAt);
        if(!$name) throw new NullException("name");
        if(strlen(trim($name)) == 0) throw new NullException("name");
        $this->name = $name;
        $this->models = new ModelCollection();
    }


    static function newInstance($uuid, $name, $createdAt, $updatedAt):BrandInterface {
        try {
            return new Brand($uuid, $name, $createdAt, $updatedAt);
        } catch (\Throwable $th) {
            return new NullBrand();
        }
    }
    static function newStrictInstance($uuid, $name, $createdAt, $updatedAt):BrandInterface {
        return new Brand($uuid, $name, $createdAt, $updatedAt);
    }

    static function createNewBrand($uuid, $name, $createdAt, $updatedAt):BrandInterface {
        $brand = new Brand($uuid, $name, $createdAt, $updatedAt);
        $brand->appendLog(new InsertLog("brands", [
            "uuid" => $brand->getUuid(),
            "name" => $brand->getName(),
            "created_at" => $brand->getCreatedAt(),
            "updated_at" => $brand->getUpdatedAt()
        ]));;
        return $brand;
    }
    function changeName($name){
        if(!$name) throw new NullException("name");
        if(strlen(trim($name)) == 0) throw new NullException("name");
        $this->name = $name;
        $this->appendLog(new UpdateLog("brands", [
            "whereCondation" => [
                "uuid" => $this->getUuid()
            ],
            "setter" => [
                "name" => $this->getName()
            ]
        ]));
    }
    function swapModelCollection(ModelCollection $modelCollection){
        $this->models = $modelCollection;
    }

    function addModel($uuid, $name, $createdAt, $updatedAt){
        $model = Model::newStrictInstance($uuid, $name, $this->getUuid(), $createdAt, $updatedAt);
        $this->models->add($model);
        $this->appendLog(new InsertLog("models", [
            "uuid" => $model->getUuid(),
            "name" => $model->getName(),
            "brand_uuid" => $model->getBrandUuid(),
            "created_at" => $model->getCreatedAt(),
            "updated_at" => $model->getUpdatedAt()
        ]));;
    }

    function changeModelName($uuid, $newName){
        $model = $this->models->getItem($uuid);
        if($model->isNull()) throw new NullException("model");
        $model->changeName($newName);
        $this->appendLog(new UpdateLog("models", [
            "whereCondation" => [
                "uuid" => $model->getUuid()
            ],
            "setter" => [
                "name" => $model->getName()
            ]
        ]));
    }
    function getName() {
        return $this->name;
    }
    function getModelUuid($uuid) {
        return $this->models->getItem($uuid)->getUuid();
    }
}