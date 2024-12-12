<?php
class DispatchOrderCommand implements Command {
    private OrderController $orderController;

    function __construct(OrderController $orderController) {
        $this->orderController = $orderController;
    }

    function process($params = []){
        $jwtAuth = new JwtAuthMiddleware();
        $isAdmin = new IsAdminMiddleware();
        $jwtAuth->linkWith(next: $isAdmin);
        $jwtAuth->check();
        $this->orderController->dispatchOrder(...$params);
    }

}