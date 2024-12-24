<?php
use Ramsey\Uuid\Uuid;
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

    static function createNewBrand($name):BrandInterface {
        $date =  date('Y-m-d H:i:s');
        $brand = new Brand(Uuid::uuid4(), $name, $date, $date);
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

    function createModel($name){
        $date =  date('Y-m-d H:i:s');
        $model = Model::newStrictInstance(Uuid::uuid4(), $name, $this->getUuid(), $date, $date);
        $this->appendLog(new InsertLog("brand_models", [
            "uuid" => $model->getUuid(),
            "name" => $model->getName(),
            "brand_uuid" => $model->getBrandUuid(),
            "created_at" => $model->getCreatedAt(),
            "updated_at" => $model->getUpdatedAt()
        ]));;
    }
    function addModel(ModelInterface $model){
        $this->models->add($model);
    }
    function deleteModel($modelUuid){
        $model = $this->models->getItem($modelUuid);
        if($model->isNull()) throw new NotFoundException("model");
        $this->appendLog(new DeleteLog("brand_models", [
            "whereCondation" => [
                "uuid" => $model->getUuid()
            ]
        ]));
    }
    function changeModelName($uuid, $newName){
        $model = $this->models->getItem($uuid);
        if($model->isNull()) throw new NullException("model");
        $model->changeName($newName);
        $this->appendLog(new UpdateLog("brand_models", [
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
        $model = $this->models->getItem($uuid);
        if($model->isNull()) throw new NullException("model");
        return $model->getUuid();
    }
    function getModels(): ModelCollection{
        return $this->models;
    }
}