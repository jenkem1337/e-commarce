<?php

interface RateRepository {
    function persist(Rate $r);
    function findOneByUuid($uuid):RateInterface;
    function findAll():RateCollection;
    function updateRateNumberByUuid(Rate $r);
    function deleteRateByUuid($uuid);
    function deleteAllByProductUuid($productUuid);
    function findAllByProductUuid($productUuid);
    function findAllByProductAggregateUuid($pUuid):IteratorAggregate;
}