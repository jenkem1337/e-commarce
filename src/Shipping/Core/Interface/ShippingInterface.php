<?php
interface ShippingInterface {
    function setStatusToCanceled();
    function isDelivered();
    function setStatusToDispatched();
    function setStateToDelivered();
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
