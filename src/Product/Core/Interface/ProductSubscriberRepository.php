<?php

interface ProductSubscriberRepository {
    function deleteByProductUuid($uuid);
    function findAllProductSubscriberByProductAggregateUuid($uuid): SubscriberCollection;
    function findAllProductSubscriberByProductUuid($uuid);
    function findOneOrEmptySubscriberByUuid($uuid, $userUuid): ProductSubscriberInterface;
}