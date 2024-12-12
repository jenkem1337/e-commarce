<?php

abstract class OrderServiceDecorator implements OrderService {
    function __construct(
        private OrderService $orderService
    ){}

    function placeOrder(PlaceOrderDto $placeOrderDto) {
        return $this->orderService->placeOrder($placeOrderDto);
    }
    function cancelOrder(OrderStatusDto $dto): ResponseViewModel {
        return $this->orderService->cancelOrder($dto);
    }

    function orderDelivered(OrderStatusDto $dto): ResponseViewModel{
        return $this->orderService->orderDelivered($dto);
    }
    function shipOrder(OrderStatusDto $dto): ResponseViewModel {
        return $this->orderService->shipOrder($dto);
    }
    function returnOrder(OrderStatusDto $dto): ResponseViewModel {
        return $this->orderService->returnOrder($dto);
    }
    function returnOrderRequest(OrderStatusDto $dto): ResponseViewModel{
        return $this->orderService->returnOrderRequest($dto);
    }
    function findAllWithItemsByUserUuid(FindAllOrderWithItemsByUserUuidDto $dto): ResponseViewModel{
        return $this->orderService->findAllWithItemsByUserUuid($dto);
    }
}