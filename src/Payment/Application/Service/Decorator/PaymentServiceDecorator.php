<?php

abstract class PaymentServiceDecorator implements PaymentService {
    private PaymentService $paymentService;
    function __construct(PaymentService $paymentService) {
        $this->paymentService = $paymentService;
    }

    function payWithCreditCart(PayWithCreditCartDto $dto) {
        return $this->paymentService->payWithCreditCart($dto);
    }
}