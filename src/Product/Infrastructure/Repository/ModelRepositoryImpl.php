<?php
class ModelRepositoryImpl implements ModelRepository {
    private ModelDao $modelDao;
    function __construct(ModelDao $modelDao) {
        $this->modelDao = $modelDao;
    } 
    function findAllByBrandUuid($brandUuid) {
        return $this->modelDao->findAllByBrandUuid($brandUuid);
    }

    function findOneEntityByUuid($uuid): ModelInterface{
        $modelObj = $this->modelDao->findOneByUuid($uuid);
        return Model::newInstance(
            $modelObj->uuid,
            $modelObj->name,
            $modelObj->brand_uuid,
            $modelObj->created_at,
            $modelObj->updated_at
        );
        
    }

    function deleteByBrandUuid($brandUuid){
        $this->modelDao->deleteByBrandUuid($brandUuid);
    }

    function findOneByUuid($uuid){
        return $this->modelDao->findOneByUuid($uuid);
    }
}