<?php

class RemoteCheckoutServiceImpl implements RemoteCheckoutService {
    function __construct(
        private RemoteCheckoutDataSource $remoteCheckoutDataSource
    ){}
    function findAmoundAndItemsByUuid($checkoutUuid, $jwtToken):ResponseViewModel {
        $checkout = $this->remoteCheckoutDataSource->findAmoundAndItemsByUuid($checkoutUuid, $jwtToken);
        return new SuccessResponse([
            "data" => $checkout
        ]);
    }
}