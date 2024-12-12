<?php
class ShippingDeliveredCommand implements Command {
    function __construct(
        private ShippingController $shippingController
    ){}

    function process($params = []){
        $jwtAuth = new JwtAuthMiddleware();
        $isAdmin = new IsAdminMiddleware();

        $jwtAuth->linkWith($isAdmin);
        
        $jwtAuth->check();

        $this->shippingController->shippingDelivered(...$params);
    }
}