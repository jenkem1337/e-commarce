<?php
interface BrandDao extends SaveChangesInterface, DatabaseTransaction {
    function findOneByUuid($uuid);
    function findAll();
    function deleteByUuid($uuid);
} 