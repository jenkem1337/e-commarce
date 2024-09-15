<?php
interface ShippingInterface {
    function changePrice($price);
    function setShippingAddress($shippingAddress);
    function changeShippingAddress($shippingAddress);
    function getShippingType();
    function getShippingState();
    function getWhenWillFinish();
    function  getPrice();
    function getShippingAddress();
    function getUuid();
    function getCreatedAt();
    function getUpdatedAt();
    function isNull();
}
