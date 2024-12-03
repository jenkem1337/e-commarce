<?php
interface ShippingRepository {
    function saveChanges(Shipping $shipping);
    function findAll();
    function findOneByUuid($uuid): ShippingInterface;
}