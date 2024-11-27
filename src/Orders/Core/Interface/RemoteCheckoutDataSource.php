<?php

interface RemoteCheckoutDataSource {
    function findAmoundAndItemsByUuid($checkoutUuid, $token);
    function completeCheckout($checkoutUuid);
}