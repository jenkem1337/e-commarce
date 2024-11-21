<?php

class OrderServiceImpl implements OrderService {
    function __construct(
        private OrderRepository $orderRepository,
        private PaymentService $paymentService,
        private ShippingService $shippingService,
        private ProductService $productService,
        private EmailService $emailService
    ){}

    function placeOrder(PlaceOrderDto $placeOrderDto){
        
        $order = Order::placeOrder(
            $placeOrderDto->getUserUuid(),
            $placeOrderDto->getAmount(),
            $placeOrderDto->getOrderItems()
        );
        $shipmentResponse = $this->shippingService->createShippingForOrderCreation(new CreationalShippingDto($order->getAmount(), $placeOrderDto->getAddressTitle(),$placeOrderDto->getAddressOwnerName(),$placeOrderDto->getAddressOwnerSurname(),$placeOrderDto->getFullAddress(),$placeOrderDto->getAddressCountry(),$placeOrderDto->getAddressProvince(),$placeOrderDto->getAddressDistrict(),$placeOrderDto->getAddressZipCode()))
                                            ->getData();
        $order->determineLatestAmount($shipmentResponse["price"]);
        
        $paymentResponse = $this->paymentService->pay(new PayOrderDto($placeOrderDto->getUserUuid(), $placeOrderDto->getPaymentMethod(), $placeOrderDto->getPaymentDetail(), $order->getAmount()))
                                        ->getData();
        
        
        $order->setStateToProcessingAndAssignPaymentAndShippingUuid($paymentResponse["uuid"], $shipmentResponse["uuid"]);
        
        $this->productService->checkQuantityAndDecrease(new CheckAndDecreaseProductsDto($order->getItems()));

        $this->orderRepository->saveChanges($order);
        
        //$this->emailService->notifyUserForOrderCreated($placeOrderDto);
        return new SuccessResponse([
            "message" => "Order created successfully !!",
            "data" => [
                "uuid" => $order->getUuid(),
                "amount" => $order->getAmount(),
                "order_items" => $order->getItems()
            ]
        ]);
    }
}