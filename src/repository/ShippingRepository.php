<?php
interface ShippingRepository {
    function findAll():IteratorAggregate;
    function findOneByUuid($uuid): ShippingInterface;
}