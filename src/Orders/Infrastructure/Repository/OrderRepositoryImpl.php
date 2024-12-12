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
            $orderObj->shipment_uuid,
            $orderObj->amount,
            OrderStatusFactory::fromValue($orderObj->status),
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
            OrderStatusFactory::fromValue($orderObject->status),
            $orderObject->created_at,
            $orderObject->updated_at
        );
    }
    function findAllWithItemsByUserUuid($userUuid): array{
        $orderList = [];
        $orders = $this->orderDao->findAllByUserUuid($userUuid);
        foreach($orders as $order) {
            $items = $this->orderDao->findAllItemsByOrderUuid($order->uuid);
            $order->items = $items;
            $orderList[] = $order;
        }
        return $orderList;
    }
}