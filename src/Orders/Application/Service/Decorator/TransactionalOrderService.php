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

    function cancelOrder(OrderStatusDto $dto): ResponseViewModel {
        try {
            $this->transactionalRepository->beginTransaction();
            $response = parent::cancelOrder($dto);
            $this->transactionalRepository->commit();
            return $response;
        } catch (\Throwable $th) {
            $this->transactionalRepository->rollBack();
            throw $th;
        }
    }

    function orderDelivered(OrderStatusDto $dto): ResponseViewModel{
        try {
            $this->transactionalRepository->beginTransaction();
            $response = parent::orderDelivered($dto);
            $this->transactionalRepository->commit();
            return $response;
        } catch (\Throwable $th) {
            $this->transactionalRepository->rollBack();
            throw $th;
        }
    }
    function shipOrder(OrderStatusDto $dto): ResponseViewModel {
        try {
            $this->transactionalRepository->beginTransaction();
            $response = parent::shipOrder($dto);
            $this->transactionalRepository->commit();
            return $response;
        } catch (\Throwable $th) {
            $this->transactionalRepository->rollBack();
            throw $th;
        }
    }
    function returnOrder(OrderStatusDto $dto): ResponseViewModel {
        try {
            $this->transactionalRepository->beginTransaction();
            $response = parent::returnOrder($dto);
            $this->transactionalRepository->commit();
            return $response;
        } catch (\Throwable $th) {
            $this->transactionalRepository->rollBack();
            throw $th;
        }
    }
    function returnOrderRequest(OrderStatusDto $dto): ResponseViewModel{
        try {
            $this->transactionalRepository->beginTransaction();
            $response = parent::returnOrderRequest($dto);
            $this->transactionalRepository->commit();
            return $response;
        } catch (\Throwable $th) {
            $this->transactionalRepository->rollBack();
            throw $th;
        }
    }

}