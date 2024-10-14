<?php
interface ModelRepository {
    function findOneEntityByUuid($uuid):ModelInterface;
    function findAllByBrandUuid($brandUuid);
    function deleteByBrandUuid($brandUuid);
}