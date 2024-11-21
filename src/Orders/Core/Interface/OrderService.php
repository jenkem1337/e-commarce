<?php

interface OrderService {
    function placeOrder(PlaceOrderDto $placeOrderDto);
}