<?php

interface RemoteCheckoutDataSource {
    function findAmoundAndItemsByUuid($checkoutUuid, $token);
}