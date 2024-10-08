<?php

class ImageRepositoryImpl implements ImageRepository {
    private ImageDao $imageDao;
    function __construct(ImageDao $imgDao)
    {
        $this->imageDao = $imgDao;
    }
    function persist(Image $i)
    {
        $this->imageDao->persist($i);
    }
    function deleteByUuid($uuid)
    {
        $this->imageDao->deleteByUuid($uuid);
    }
    function deleteAllByProductUuid($productUuid){
        $this->imageDao->deleteAllByProductUuid($productUuid);
    }
    function findAll():IteratorAggregate
    {
        $imageObjects = $this->imageDao->findAll();
        $imageArray = new ImageCollection();
        foreach($imageObjects as $imageObject){
            $imageDomainObject = Image::newInstance(
                $imageObject->uuid,
                $imageObject->product_uuid,
                $imageObject->image_name,
                $imageObject->location,

                $imageObject->created_at,
                $imageObject->updated_at
            );
            $imageArray->add($imageDomainObject);
        }
        return $imageArray;
    }
    function findAllByProductUuid($pUuid): mixed {
        return $this->imageDao->findAllByProductUuid($pUuid);
    }
    function findAllByProductAggregateUuid($pUuid):IteratorAggregate
    {
        $imageObjects = $this->imageDao->findAllByProductUuid($pUuid);
        $imageArray = new ImageCollection();
        foreach($imageObjects as $imageObject){
            $imageDomainObject = Image::newInstance(
                $imageObject->uuid,
                $imageObject->product_uuid,
                $imageObject->image_name,
                $imageObject->location,

                $imageObject->created_at,
                $imageObject->updated_at
            );
            if(!$imageDomainObject->isNull()){
                $imageArray->add($imageDomainObject);
            }
        }
        return $imageArray;

    }
    function findImageByProductUuid($pUuid):ImageInterface
    {
        $imageObject = $this->imageDao->findImageByProductUuid($pUuid);
        $imageDomainObject = Image::newInstance(
            $imageObject->uuid,
            $imageObject->product_uuid,
            $imageObject->image_name,
            $imageObject->location,

            $imageObject->created_at,
            $imageObject->updated_at
        );
        return $imageDomainObject;
    }
    function findOneByUuid($uuid):ImageInterface
    {
        $imageObject = $this->imageDao->findOneByUuid($uuid);
        $imageDomainObject = Image::newInstance(
            $imageObject->uuid,
            $imageObject->product_uuid,
            $imageObject->image_name,
            $imageObject->location,
            $imageObject->created_at,
            $imageObject->updated_at
        );
        return $imageDomainObject;

    }
    function setProductMediator(AbstractProductRepositoryMediatorComponent $mediator){
        $mediator->setImageRepository($this);
    }
}