<?php
interface RateDao{
    function findOneByUuid($uuid);
    function findAll();
    function findOneByProductUuidAndUserUuid($productUuid, $userUuid);
    function deleteRateByUuid($uuid);
    function deleteAllByProductUuid($productUuid);
    function findAllByProductUuid($pUuid);
}