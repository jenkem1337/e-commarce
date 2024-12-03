<?php

interface OrderService {
    function placeOrder(PlaceOrderDto $placeOrderDto);
    function orderDelivered(OrderStatusDto $dto): ResponseViewModel;
    function shipOrder(OrderStatusDto $dto):ResponseViewModel;
    function cancelOrder(OrderStatusDto $dto):ResponseViewModel;
}