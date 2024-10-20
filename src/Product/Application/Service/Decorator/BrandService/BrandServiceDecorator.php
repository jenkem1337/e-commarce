<?php

abstract class BrandServiceDecorator implements BrandService {
    private BrandService $brandService;

    function __construct(BrandService $brandService){
        $this->brandService = $brandService;
    }
    function createBrand(CreationalBrandDto $creationalBrandDto):ResponseViewModel{
        return $this->brandService->createBrand($creationalBrandDto);
    }
    function createBrandModel(CreateBrandModelDto $createBrandModelDto):ResponseViewModel{
        return $this->brandService->createBrandModel($createBrandModelDto);
    }
    function changeBrandName(ChangeBrandNameDto $changeBrandNameDto):ResponseViewModel{
        return $this->brandService->changeBrandName($changeBrandNameDto);
    }
    function changeBrandModelName(ChangeBrandModelNameDto $changeBrandModelNameDto): ResponseViewModel{
        return $this->brandService->changeBrandModelName($changeBrandModelNameDto);
    }
    function deleteBrand(DeleteBrandDto $deleteBrandDto): ResponseViewModel{
        return $this->brandService->deleteBrand($deleteBrandDto);
    }
    function findOneBrandWithModels(FindOneBrandWithModelsDto $findOneBrandWithModelsDto):ResponseViewModel{
        return $this->brandService->findOneBrandWithModels($findOneBrandWithModelsDto);
    }
    function findAll():ResponseViewModel{
        return $this->brandService->findAll();
    }

}