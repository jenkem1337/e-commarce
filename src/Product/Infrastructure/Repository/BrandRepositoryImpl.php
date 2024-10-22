<?php

class BrandRepositoryImpl extends TransactionalRepository implements BrandRepository {
    private BrandDao $brandDao;
    private ModelRepository $modelRepository;
    function __construct(BrandDao $brandDao, ModelRepository $modelRepository) {
        $this->brandDao = $brandDao;
        $this->modelRepository = $modelRepository;
        parent::__construct($this->brandDao);
    }
    function saveChanges(Brand $brand){
        $this->brandDao->saveChanges($brand);
    }

    function findOneAggregateByUuid($uuid): BrandInterface{
        $brandObject = $this->brandDao->findOneByUuid($uuid);
        return Brand::newInstance(
            $brandObject->uuid,
            $brandObject->name,
            $brandObject->created_at,
            $brandObject->updated_at
        );
    }
    function findOneOnlyWithSingleModelByUuidAndModelUuid($brandUuid,$modelUuid):BrandInterface{
        $modelEntity = $this->modelRepository->findOneEntityByUuid($modelUuid);
        $brandObject = $this->brandDao->findOneByUuid($brandUuid);
        $brandDomainModel = Brand::newInstance(
            $brandObject->uuid,
            $brandObject->name,
            $brandObject->created_at,
            $brandObject->updated_at
        );
        if(!$modelEntity->isNull()){
            $brandDomainModel->addModel($modelEntity);
        }
        return $brandDomainModel;
    }
    
    function findAll(){
        $brandObjects = $this->brandDao->findAll();
        if($brandObjects[0]->uuid == null) {
            return [];
        }
        foreach ($brandObjects as $brand) {
            $modelObjects = $this->modelRepository->findAllByBrandUuid($brand->uuid);
            $brand->models = $modelObjects;
        }
        
        return $brandObjects;
    }

    function findOneWithModels($uuid){
        $brandObject = $this->brandDao->findOneByUuid($uuid);
        if($brandObject->uuid == null) return null;
        $modelObjects = $this->modelRepository->findAllByBrandUuid($brandObject->uuid);
        $brandObject->models = $modelObjects;
        return $brandObject; 
    }
    function findOneWithSingleModel($brandUuid, $modelUuid){
        $brandObject = $this->brandDao->findOneByUuid($brandUuid);
        $modelObject = $this->modelRepository->findOneByUuid($modelUuid);
        
        $brandObject->model = $modelObject;
        return $brandObject;
        
    }
    function deleteBrand(Brand $brand){
        $this->modelRepository->deleteByBrandUuid($brand->getUuid());
        $this->brandDao->deleteByUuid($brand->getUuid());
    }

}