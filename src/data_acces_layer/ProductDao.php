<?php

interface ProductDao {
    function persist(Product $p);
    function persistSubscriber(ProductSubscriber $ps);
    function deleteSubscriberByUserUuid($uuid);
    function deleteSubscriberByProductUuid($pUuid);
    function deleteByUuid($uuid);
    function findAll();
    function findAllProductSubscriberByProductUuid($uuid);
    function findSubscriberByUserUuid($userUuid);
    function findAllWithPagination($startingLimit, $perPageForUsers);
    function findOneByUuid($uuid);
    function findBySearching($value);
    function updateStockQuantityByUuid(Product $p);
    function updateModelNameByUuid(Product $p);
    function updateBrandNameByUuid(Product $p);
    function updatePriceByUuid(Product $p);
    function updateDescriptionByUuid(Product $p);
    function updateHeaderByUuid(Product $p);
    function updateAvarageRateByUuid(Product $p);
}