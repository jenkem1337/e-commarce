<?php

interface ProductDao extends SaveChangesInterface{
    function persist(Product $p);
    function deleteSubscriberByProductUuid($pUuid);
    function deleteByUuid($uuid);
    function findProductsByCriteria();
    function findAllProductSubscriberByProductUuid($uuid);
    function findSubscriberByUserUuid($userUuid);
    function findOneByUuid($uuid);
    function findBySearching($value, $startingLimit, $perPageForUsers);
    function findOneOrEmptySubscriberByUuid($uuid, $userUuid);
}