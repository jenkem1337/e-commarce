<?php

interface ProductSubscriberRepository {
    function persist(ProductSubscriber $productSubscriber);
    function deleteByProductUuidAndUserUuid($uUuid, $pUuid);
    function deleteByProductUuid($uuid);
    function findAllProductSubscriberByProductUuid($uuid): SubscriberCollection;
    function findOneOrEmptySubscriberByUuid($uuid, $userUuid): ProductSubscriberInterface;
}