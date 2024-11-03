<?php

class PaymentServiceImpl implements PaymentService {
    function __construct(
        private PaymentRepository $paymentRepository,
        private PaymentGateway $paymentGateway
    ){}
    function payWithCreditCart(PayWithCreditCartDto $dto){
        $payment = Payment::payWithCreditCart()
    }
}