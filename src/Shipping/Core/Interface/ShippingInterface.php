<?php
interface ShippingInterface {
    function getShippingType():Type;
    function getShippingState();
    function getUuid();
    function getAddressTitle();
    function getAddressOwnerName();
    function getAddressOwnerSurname();
    function getFullAddress();
    function getAddressCountry();
    function getAddressProvince();
    function getAddressDistrict();
    function getAddressZipCode();
    function getCreatedAt();
    function getUpdatedAt();
    function isNull();
}
