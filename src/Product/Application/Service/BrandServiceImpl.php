<?php

class BrandServiceImpl implements BrandService {
    private BrandRepository $brandRepository;
    function __construct(BrandRepository $brandRepository){
        $this->brandRepository = $brandRepository;
    }

    function createBrand(CreationalBrandDto $creationalBrandDto):ResponseViewModel{
        $brand = Brand::createNewBrand($creationalBrandDto->name());
        $this->brandRepository->saveChanges($brand);
        return new SuccessResponse([
            "message" => "Brand created successfully"
        ]);

    }

    function createBrandModel(CreateBrandModelDto $createBrandModelDto):ResponseViewModel{
        $brand = $this->brandRepository->findOneAggregateByUuid($createBrandModelDto->brandUuid());
        if($brand->isNull()) throw new NotFoundException("brand");
        $brand->createModel($createBrandModelDto->modelName());
        $this->brandRepository->saveChanges($brand);
        return new SuccessResponse([
            "message" => "Brand model created successfully"
        ]);
    }

    function changeBrandName(ChangeBrandNameDto $changeBrandNameDto):ResponseViewModel{
        $brand = $this->brandRepository->findOneAggregateByUuid($changeBrandNameDto->uuid());
        if($brand->isNull()) throw new NotFoundException("brand");
        $brand->changeName($changeBrandNameDto->name());
        $this->brandRepository->saveChanges($brand);
        return new SuccessResponse([
            "message" => "Brand name updated successfully"
        ]);

    }
    function changeBrandModelName(ChangeBrandModelNameDto $changeBrandModelNameDto):ResponseViewModel{
        $brand = $this->brandRepository->findOneOnlyWithSingleModelByUuidAndModelUuid($changeBrandModelNameDto->brandUuid(), $changeBrandModelNameDto->modelUuid());
        if($brand->isNull()) throw new NotFoundException("brand");
        $brand->changeModelName($changeBrandModelNameDto->modelUuid(), $changeBrandModelNameDto->name());
        $this->brandRepository->saveChanges($brand);
        return new SuccessResponse([
            "message" => "Brand updated successfully"
        ]);

    }

    function deleteBrand(DeleteBrandDto $deleteBrandDto): ResponseViewModel{
        $brand = $this->brandRepository->findOneAggregateByUuid($deleteBrandDto->uuid());
        if($brand->isNull()) throw new NotFoundException("brand");
        $this->brandRepository->deleteBrand($brand);
        return new SuccessResponse([
            "message" => "Brand deleted successfully"
        ]);
    }

    function deleteOneBrandModel(DeleteOneBrandModelDto $deleteOneBrandModelDto):ResponseViewModel{
        $brand = $this->brandRepository->findOneOnlyWithSingleModelByUuidAndModelUuid($deleteOneBrandModelDto->brandUuid(), $deleteOneBrandModelDto->modelUuid());
        if($brand->isNull()) throw new NotFoundException("brand");
        $brand->deleteModel($deleteOneBrandModelDto->modelUuid());
        $this->brandRepository->saveChanges($brand);
        return new SuccessResponse([
            "message" => "Brand model deleted successfully"
        ]);
    }

    function findOneBrandWithModels(FindOneBrandWithModelsDto $findOneBrandWithModelsDto):ResponseViewModel{
        $brand = $this->brandRepository->findOneWithModels($findOneBrandWithModelsDto->uuid());
        if($brand == null) throw new NotFoundException("brand");
        return new SuccessResponse([
            "data" => $brand
        ]);
    }
    function findAll():ResponseViewModel{
        $brands = $this->brandRepository->findAll();
        return new SuccessResponse([
            "data" => $brands
        ]);
    }
}