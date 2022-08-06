<?php
interface RateDao{
    function persist(Rate $r);
    function findOneByUuid($uuid);
    function findAll();
    function updateRateNumberByUuid(Rate $r);
    function deleteRateByUuid($uuid);
    function findAllByProductUuid($pUuid);
}