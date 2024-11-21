<?php

class TransactionalOrderService extends OrderServiceDecorator {
    private TransactionalRepository $transactionalRepository;
    function __construct(OrderService $orderService, TransactionalRepository $orderRepository){
        parent::__construct($orderService);
        $this->transactionalRepository = $orderRepository;
    }

    function placeOrder(PlaceOrderDto $placeOrderDto):ResponseViewModel{
        try {
            $this->transactionalRepository->beginTransaction();
            $response = parent::placeOrder($placeOrderDto);
            $this->transactionalRepository->commit();
            return $response;
        } catch (\Throwable $th) {
            $this->transactionalRepository->rollBack();
            throw $th;
        }
    }
}