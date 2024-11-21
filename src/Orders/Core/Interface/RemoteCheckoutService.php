<?php

interface RemoteCheckoutService {
    function findAmoundAndItemsByUuid($checkoutUuid, $token): ResponseViewModel;
}