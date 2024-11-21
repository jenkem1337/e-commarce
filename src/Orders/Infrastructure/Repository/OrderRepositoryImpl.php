<?php

class OrderRepositoryImpl extends TransactionalRepository implements OrderRepository {
    private OrderDao $orderDao;

    function __construct(OrderDao $dataAccessObject){
        $this->orderDao = $dataAccessObject;
        parent::__construct($this->orderDao);
    }

    function saveChanges(Order $order){
        $this->orderDao->saveChanges($order);
    }
}