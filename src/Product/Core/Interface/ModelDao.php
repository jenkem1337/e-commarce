<?php

interface ModelDao {
    function findAllByBrandUuid($uuid);
    function findOneByUuid($uuid);
    function deleteByBrandUuid($brandUuid);
}