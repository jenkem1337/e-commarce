<?php

abstract class OrderServiceDecorator implements OrderService {
    function __construct(
        private OrderService $orderService
    ){}

    function placeOrder(PlaceOrderDto $placeOrderDto) {
        return $this->orderService->placeOrder($placeOrderDto);
    }
}