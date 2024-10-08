<?php
class ProductSubscriberRepositoryImpl implements ProductSubscriberRepository {
    private ProductDao $productDao;
    function __construct(ProductDao $productDao){
        $this->productDao = $productDao;
    }   

    function deleteByProductUuid($productUuid){
        $this->productDao->deleteSubscriberByProductUuid($productUuid);
    }
    function findAllProductSubscriberByProductUuid($uuid) {
        return $this->productDao->findAllProductSubscriberByProductUuid($uuid);
    }
    function findAllProductSubscriberByProductAggregateUuid($uuid): SubscriberCollection{
        $productSubscriberObjects = $this->productDao->findAllProductSubscriberByProductUuid($uuid);
        $subscriberIterator = new SubscriberCollection();

        foreach($productSubscriberObjects as $subscriber){
            $productSubscriberDomainObject = ProductSubscriber::newInstance(
                
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
        $productSubscriberDomainObject = ProductSubscriber::newInstance(
            $subscriberObj->uuid,
            $subscriberObj->product_uuid,
            $subscriberObj->user_uuid,
            $subscriberObj->created_at,
            $subscriberObj->updated_at
        );
        if(isset($subscriberObj->email) && isset($subscriberObj->full_name)){
            $productSubscriberDomainObject->setUserEmail($subscriberObj->email);
            $productSubscriberDomainObject->setUserFullName($subscriberObj->full_name);    
        }
        return $productSubscriberDomainObject;
    }

    function setProductMediator(AbstractProductRepositoryMediatorComponent $mediator)
    {
        $mediator->setProductSubscriberRepository($this);
    }
}