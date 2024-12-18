<?php

interface RateRepository {
    function findOneByUuid($uuid):RateInterface;
    function findAll():RateCollection;
    function deleteRateByUuid($uuid);
    function deleteAllByProductUuid($productUuid);
    function findAllByProductUuid($productUuid);
    function findAllByProductAggregateUuid($pUuid):IteratorAggregate;
    function findOneByProductUuidAndUserUuid($productUuid, $userUuid): RateInterface;
}