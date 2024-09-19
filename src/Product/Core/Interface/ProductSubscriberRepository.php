<?php

interface ProductSubscriberRepository {
    function deleteByProductUuid($uuid);
    function findAllProductSubscriberByProductUuid($uuid): SubscriberCollection;
    function findOneOrEmptySubscriberByUuid($uuid, $userUuid): ProductSubscriberInterface;
}