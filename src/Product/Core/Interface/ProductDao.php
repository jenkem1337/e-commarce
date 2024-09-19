<?php

interface ProductDao extends SaveChangesInterface{
    function persist(Product $p);
    function persistSubscriber(ProductSubscriber $ps);
    function deleteSubscriberByUserAndProductUuid($userUuid, $productUuid);
    function deleteSubscriberByProductUuid($pUuid);
    function deleteByUuid($uuid);
    function findAll();
    function findAllProductSubscriberByProductUuid($uuid);
    function findSubscriberByUserUuid($userUuid);
    function findAllWithPagination($startingLimit, $perPageForUsers);
    function findOneByUuid($uuid);
    function findByPriceRange($from, $to);
    function findBySearching($value, $startingLimit, $perPageForUsers);
    function findOneOrEmptySubscriberByUuid($uuid, $userUuid);
}