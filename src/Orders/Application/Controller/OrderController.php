<?php

class OrderController {
    function __construct(
        private OrderService $orderService,
        private RemoteCheckoutService $remoteCheckoutService
    ){}

    function findAllWithItemsByUserUuid($userUuid) {
        $response = $this->orderService->findAllWithItemsByUserUuid(
            new FindAllOrderWithItemsByUserUuidDto($userUuid)
        );
        http_response_code(200);
        echo json_encode($response);

    }
    function placeOrder(){
        
        
        $jsonBody = json_decode(file_get_contents('php://input'));
        
        $checkout = $this->remoteCheckoutService->findAmoundAndItemsByUuid($jsonBody->checkout_uuid, explode(' ', $_SERVER['HTTP_AUTHORIZATION'])[1])
                                                ->getData();
        
        $jwtPayloadDto = JwtPayloadDto::getInstance();        
        $jwtPayload = $jwtPayloadDto->getPayload();
        

        $response = $this->orderService->placeOrder(
            new PlaceOrderDto(
                $jwtPayload->user_uuid,
                $jsonBody->email,
                $jsonBody->peyment_method,
                $jsonBody->peyment_detail,
                $checkout->subTotal,
                $jsonBody->order_address->title,
                $jsonBody->order_address->name,
                $jsonBody->order_address->surname,
                $jsonBody->order_address->full_address,
                $jsonBody->order_address->country,
                $jsonBody->order_address->province,
                $jsonBody->order_address->district,
                $jsonBody->order_address->postal_code,
                $checkout->checkoutItemDocument
            )
        );
        $this->remoteCheckoutService->completeCheckout($checkout->uuid);
        http_response_code(201);
        echo json_encode($response);

        $jwtPayloadDto->removePayload();

    }

    function dispatchOrder($orderUuid) {
        $response = $this->orderService->shipOrder(new OrderStatusDto($orderUuid));
        http_response_code(201);
        echo json_encode($response);
    }

    function completeOrder($orderUuid) {
        $response = $this->orderService->orderDelivered(new OrderStatusDto($orderUuid));
        http_response_code(201);
        echo json_encode($response);
    }

    function cancelOrder($orderUuid) {
        $response = $this->orderService->cancelOrder(new OrderStatusDto($orderUuid));
        http_response_code(201);
        echo json_encode($response);
    }

    function sendReturnRequest($orderUuid) {
        $response = $this->orderService->returnOrderRequest(new OrderStatusDto($orderUuid));
        http_response_code(201);
        echo json_encode($response);
    }

    function returnOrder($orderUuid) {
        $response = $this->orderService->returnOrder(new OrderStatusDto($orderUuid));
        http_response_code(201);
        echo json_encode($response);
    }
}