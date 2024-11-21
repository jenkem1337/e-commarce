<?php

interface ProductDao extends SaveChangesInterface, DatabaseTransaction{
    function deleteSubscriberByProductUuid($pUuid);
    function deleteByUuid($uuid);
    function findProductsByCriteria(FindProductsByCriteriaDto $findProductsByCriteriaDto);
    function findAllProductSubscriberByProductUuid($uuid);
    function findSubscriberByUserUuid($userUuid);
    function findOneByUuid($uuid);
    function findBySearching($value, $startingLimit, $perPageForUsers);
    function findOneOrEmptySubscriberByUuid($uuid, $userUuid);
    function findManyByUuids($uuids);
}