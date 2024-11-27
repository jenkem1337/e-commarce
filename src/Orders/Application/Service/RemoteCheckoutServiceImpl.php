<?php

class RemoteCheckoutServiceImpl implements RemoteCheckoutService {
    function __construct(
        private RemoteCheckoutDataSource $remoteCheckoutDataSource
    ){}
    function findAmoundAndItemsByUuid($checkoutUuid, $jwtToken):ResponseViewModel {
        $checkout = $this->remoteCheckoutDataSource->findAmoundAndItemsByUuid($checkoutUuid, $jwtToken);
        if($checkout->checkoutState !== "CHECKOUT_CREATED") {
            throw new CheckoutStateNotSuitableException();
        }
        return new SuccessResponse([
            "data" => $checkout
        ]);
    }

    function completeCheckout($checkoutUuid) {
        $this->remoteCheckoutDataSource->completeCheckout($checkoutUuid);
    }
}