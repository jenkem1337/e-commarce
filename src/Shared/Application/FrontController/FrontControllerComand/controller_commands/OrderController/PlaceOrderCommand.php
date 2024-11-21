<?php


class PlaceOrderCommand implements Command {
    function __construct(
        private OrderController $orderController
    ){}
    function process($params = []) {
        $middleware = new JwtAuthMiddleware();
        $middleware->check();
        $this->orderController->placeOrder();
    }
}