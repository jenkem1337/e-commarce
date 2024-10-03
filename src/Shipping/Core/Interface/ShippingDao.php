<?php
interface ShippingDao extends SaveChangesInterface, DatabaseTransaction {
    function findAll();
    function findOneByUuid($uuid);
}