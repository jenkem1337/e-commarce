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

    function findOneAggregateWithItemsByUuid($uuid):OrderInterface {
        $orderObj = $this->orderDao->findOneByUuid($uuid);
        $orderItemsObj = $this->orderDao->findAllItemsByOrderUuid($uuid);
        $itemCollection = new OrderItemCollection();
        foreach($orderItemsObj as $item) {
            $itemCollection->add(
                OrderItem::newInstance(
                    $item->uuid,
                    $item->order_uuid,
                    $item->product_uuid,
                    $item->quantity,
                    $item->created_at,
                    $item->updated_at
                )
            );
        }

        return Order::newInstanceWithItems(
            $orderObj->uuid,
            $orderObj->user_uuid,
            $orderObj->payment_uuid,
            $orderObj->shipping_uuid,
            $orderObj->amount,
            $orderObj->status,
            $itemCollection,
            $orderObj->created_at,
            $orderObj->updated_at
        );
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