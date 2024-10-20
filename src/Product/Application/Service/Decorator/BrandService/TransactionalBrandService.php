<?php

class TransactionalBrandService extends BrandServiceDecorator {
    private TransactionalRepository $brandRepository;
    function __construct(BrandService $brandService, TransactionalRepository $brandRepository){
        $this->brandRepository = $brandRepository;
        parent::__construct($brandService);
    }

    function createBrand(CreationalBrandDto $creationalBrandDto):ResponseViewModel{
        try {
            
            $this->brandRepository->beginTransaction();
            $response = parent::createBrand($creationalBrandDto);
            
            $this->brandRepository->commit();
            return $response;
        } catch (Exception $e) {
            $this->brandRepository->rollback();
            throw $e;
        } 
    }
    
    function createBrandModel(CreateBrandModelDto $createBrandModelDto):ResponseViewModel{
        try {
            
            $this->brandRepository->beginTransaction();
            $response = parent::createBrandModel($createBrandModelDto);
            
            $this->brandRepository->commit();
            return $response;
        } catch (Exception $e) {
            $this->brandRepository->rollback();
            throw $e;
        } 
    }
    function changeBrandName(ChangeBrandNameDto $changeBrandNameDto):ResponseViewModel{
        try {
            
            $this->brandRepository->beginTransaction();
            $response = parent::changeBrandName($changeBrandNameDto);
            
            $this->brandRepository->commit();
            return $response;
        } catch (Exception $e) {
            $this->brandRepository->rollback();
            throw $e;
        } 
    }
    function changeBrandModelName(ChangeBrandModelNameDto $changeBrandModelNameDto): ResponseViewModel{
        try {
            
            $this->brandRepository->beginTransaction();
            $response = parent::changeBrandModelName($changeBrandModelNameDto);
            
            $this->brandRepository->commit();
            return $response;
        } catch (Exception $e) {
            $this->brandRepository->rollback();
            throw $e;
        } 
    }
    function deleteBrand(DeleteBrandDto $deleteBrandDto): ResponseViewModel{
        try {
            
            $this->brandRepository->beginTransaction();
            $response = parent::deleteBrand($deleteBrandDto);
            
            $this->brandRepository->commit();
            return $response;
        } catch (Exception $e) {
            $this->brandRepository->rollback();
            throw $e;
        } 
    }
    function findOneBrandWithModels(FindOneBrandWithModelsDto $findOneBrandWithModelsDto):ResponseViewModel{
        return parent::findOneBrandWithModels($findOneBrandWithModelsDto);
    }
    function findAll():ResponseViewModel{
        return parent::findAll();
    }

}