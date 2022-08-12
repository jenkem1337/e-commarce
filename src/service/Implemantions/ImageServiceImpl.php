<?php

class ImageServiceImpl implements ImageService {
    private ProductRepository $productAggregateRepository;
    private UploadService $uploadService;
    private ImageFactory $imageFactory;
    

	function __construct(ProductRepository $productAggregateRepository, UploadService $uploadService, ImageFactory $imageFactory) {
	    $this->productAggregateRepository = $productAggregateRepository;
	    $this->uploadService = $uploadService;
	    $this->imageFactory = $imageFactory;
	}
    function uploadImageForProduct(ImageCreationalDto $dto): ResponseViewModel
    {
        $productDomainObject = $this->productAggregateRepository->findOneProductByUuid($dto->getProductUuid());
        if($productDomainObject->isNull()) throw new NotFoundException('product');
        
        if(count( $productDomainObject->getImages()->getItems() ) >= 1){
            $productDomainObject->getImages()->clearItems();
        }
        
        
        foreach($dto->getImageIterator() as $imageObject){
            $imageDomainObject= $this->imageFactory->createInstance(
                true,
                $imageObject->uuid,
                $imageObject->productUuid,
                $imageObject->imageName,
                $imageObject->createdAt,
                $imageObject->updatedAt
            );
            $productDomainObject->addImage($imageDomainObject);
        }
        
        $this->productAggregateRepository->persistImage($productDomainObject);
        $this->uploadService->uploadNewProductImages($dto->getImageIterator(), $productDomainObject->getUuid());
        
        return new ImageCreatedResponseDto($dto->getImageIterator());
    }
    function deleteImageByUuid(DeleteImageByUuidDto $dto): ResponseViewModel
    {
        $productDomainObject = $this->productAggregateRepository->findOneProductByUuid($dto->getProductUuid());
        if($productDomainObject->isNull()) throw new NotFoundException('product');
        
        $imageDomainObject = $productDomainObject->getImages()
                                                ->getItem($dto->getImageUuid());

        if($imageDomainObject->isNull()) throw new DoesNotExistException('image');
        
        $this->productAggregateRepository->deleteImageByUuid($imageDomainObject->getUuid());
        $this->uploadService->deleteImageByUuid($imageDomainObject->getImageName(), $productDomainObject->getUuid());
        
        return new ImageDeletedResponseDto('Image deleted successfully');
    }

}