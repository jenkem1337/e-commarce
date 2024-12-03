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

    function findOneAggregateByUuid($uuid):OrderInterface{
        $orderObject = $this->orderDao->findOneByUuid($uuid); 
        return Order::newInstance(
            $orderObject->uuid,
            $orderObject->user_uuid,
            $orderObject->payment_uuid,
            $orderObject->shipment_uuid,
            $orderObject->amount,
            $orderObject->status,
            $orderObject->created_at,
            $orderObject->updated_at
        );
    }
    function findOneOrderWithItemsByUuid(){}
    function listAllOrdersByCriteria(){}
}