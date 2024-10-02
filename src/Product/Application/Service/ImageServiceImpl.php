<?php

class ImageServiceImpl implements ImageService {
    private ProductRepository $productAggregateRepository;
    private UploadService $uploadService;
    

	function __construct(ProductRepository $productAggregateRepository, UploadService $uploadService) {
	    $this->productAggregateRepository = $productAggregateRepository;
	    $this->uploadService = $uploadService;
	}
    function uploadImageForProduct(ImageCreationalDto $dto): ResponseViewModel
    {
        $productDomainObject = $this->productAggregateRepository->findOneProductAggregateByUuid($dto->getProductUuid(), [
            "comments"=>false,
            "subscribers"=>false,
            "categories"=>false,
            "rates"=> false,
            "images"=>false
        ]);
        if($productDomainObject->isNull()) throw new NotFoundException('product');        
        
        $productDomainObject->addImages($dto->getImages());        
        
        $this->productAggregateRepository->saveChanges($productDomainObject);
        
        $this->uploadService->uploadNewProductImages($dto->getImages(), $productDomainObject->getUuid());
        
        return new SuccessResponse([
            "message" => "Images uploaded successfully !",
            "data" => $dto->getImages()
        ]);
    }
    function deleteImageByUuid(DeleteImageByUuidDto $dto): ResponseViewModel
    {
        $productDomainObject = $this->productAggregateRepository->findOneProductAggregateByUuid($dto->getProductUuid(), [
            "comments"=>false,
            "subscribers"=>false,
            "categories"=>false,
            "rates"=> false,
            "images"=>"get"
        ]);
        if($productDomainObject->isNull()) throw new NotFoundException('product');
        
        $imageDomainObject = $productDomainObject->deleteImage($dto->getImageUuid());
        
        $this->productAggregateRepository->saveChanges($productDomainObject);
        
        $this->uploadService->deleteOneImageByUuid($imageDomainObject->getLocation());
        
        return new SuccessResponse([
            "message" => 'Image deleted successfully',
            "data" => ["image_uuid" => $dto->getImageUuid()]
        ]);
    }

}