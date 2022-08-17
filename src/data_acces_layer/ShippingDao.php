<?php
interface ShippingDao {
    function findAll();
    function findOneByUuid($uuid);
}