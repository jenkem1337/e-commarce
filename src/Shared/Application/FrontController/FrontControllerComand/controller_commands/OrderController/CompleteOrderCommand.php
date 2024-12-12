<?php

class CompleteOrderCommand implements Command {
    function __construct(
        private OrderController $orderController
    ){}

    function process($params = []){
        $jwtAuth = new JwtAuthMiddleware();
        $jwtAuth->check();
        $this->orderController->completeOrder(...$params);
    }
}