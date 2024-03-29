<?php
class ProductSubscriberRepositoryImpl implements ProductSubscriberRepository {
    private ProductDao $productDao;
    private ProductSubscriberFactory $productSubscriberFactory;
    function __construct(ProductDao $productDao, Factory  $productSubscriberFactory){
        $this->productDao = $productDao;
        $this->productSubscriberFactory = $productSubscriberFactory;
    }   

    function persist(ProductSubscriber $productSubscriber){
        $this->productDao->persistSubscriber($productSubscriber);
    }
    function deleteByProductUuid($productUuid){
        $this->productDao->deleteSubscriberByProductUuid($productUuid);
    }
    function deleteByProductUuidAndUserUuid($uUuid, $pUuid ){
        $this->productDao->deleteSubscriberByUserAndProductUuid($uUuid, $pUuid);
    }
    function findAllProductSubscriberByProductUuid($uuid): SubscriberCollection{
        $productSubscriberObjects = $this->productDao->findAllProductSubscriberByProductUuid($uuid);
        $subscriberIterator = new SubscriberCollection();

        foreach($productSubscriberObjects as $subscriber){
            $productSubscriberDomainObject = $this->productSubscriberFactory->createInstance(
                false,
                $subscriber->uuid,
                $subscriber->product_uuid,
                $subscriber->user_uuid,
                $subscriber->created_at,
                $subscriber->updated_at
            );

            $productSubscriberDomainObject->setUserEmail($subscriber->user_email);
            $productSubscriberDomainObject->setUserFullName($subscriber->user_full_name);
            
            if(!$productSubscriberDomainObject->isNull()) {
                $subscriberIterator->add($productSubscriberDomainObject);
            }
        }
        return $subscriberIterator;
    }
    function findOneOrEmptySubscriberByUuid($uuid, $userUuid): ProductSubscriberInterface{
        $subscriberObj = $this->productDao->findOneOrEmptySubscriberByUuid($uuid, $userUuid);
        $productSubscriberDomainObject = $this->productSubscriberFactory->createInstance(
            false,
            $subscriberObj->uuid,
            $subscriberObj->product_uuid,
            $subscriberObj->user_uuid,
            $subscriberObj->created_at,
            $subscriberObj->updated_at
        );
        $productSubscriberDomainObject->setUserEmail($subscriberObj->email);
        $productSubscriberDomainObject->setUserFullName($subscriberObj->full_name);
        return $productSubscriberDomainObject;
    }

    function setProductMediator(AbstractProductRepositoryMediatorComponent $mediator)
    {
        $mediator->setProductSubscriberRepository($this);
    }
}