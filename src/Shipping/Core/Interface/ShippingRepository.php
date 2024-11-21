<?php
interface ShippingRepository {
    function saveChanges(BaseEntity $shipping);
    function findAll();
    function findOneByUuid($uuid): ShippingInterface;
}