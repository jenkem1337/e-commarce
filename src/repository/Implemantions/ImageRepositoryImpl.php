<?php

class ImageRepositoryImpl implements ImageRepository {
    private ImageDao $imageDao;
    private ImageFactory $imageFactory;
    function __construct(ImageDao $imgDao, Factory $imgFactory)
    {
        $this->imageDao = $imgDao;
        $this->imageFactory = $imgFactory;
    }
    function persist(Image $i)
    {
        $this->imageDao->persist($i);
    }
    function deleteByUuid($uuid)
    {
        $this->imageDao->deleteByUuid($uuid);
    }
    function findAll():IteratorAggregate
    {
        $imageObjects = $this->imageDao->findAll();
        $imageArray = new ImageCollection();
        foreach($imageObjects as $imageObject){
            $imageDomainObject = $this->imageFactory->createInstance(
                false,
                $imageObject->uuid,
                $imageObject->product_uuid,
                $imageObject->image_name,
                $imageObject->created_at,
                $imageObject->updated_at
            );
            $imageArray->add($imageDomainObject);
        }
        return $imageArray;
    }
    function findAllByProductUuid($pUuid):IteratorAggregate
    {
        $imageObjects = $this->imageDao->findAllByProductUuid($pUuid);
        $imageArray = new ImageCollection();
        foreach($imageObjects as $imageObject){
            $imageDomainObject = $this->imageFactory->createInstance(
                false,
                $imageObject->uuid,
                $imageObject->product_uuid,
                $imageObject->image_name,
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
        $imageDomainObject = $this->imageFactory->createInstance(
            false,
            $imageObject->uuid,
            $imageObject->product_uuid,
            $imageObject->image_name,
            $imageObject->created_at,
            $imageObject->updated_at
        );
        return $imageDomainObject;
    }
    function findOneByUuid($uuid):ImageInterface
    {
        $imageObject = $this->imageDao->findOneByUuid($uuid);
        $imageDomainObject = $this->imageFactory->createInstance(
            false,
            $imageObject->uuid,
            $imageObject->product_uuid,
            $imageObject->image_name,
            $imageObject->created_at,
            $imageObject->updated_at
        );
        return $imageDomainObject;

    }
    function setProductMediator(AbstractProductRepositoryMediatorComponent $mediator){
        $mediator->setImageRepository($this);
    }
}