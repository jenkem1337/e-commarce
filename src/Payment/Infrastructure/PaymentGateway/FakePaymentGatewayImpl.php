<?php
class FakePaymentGatewayImpl implements PaymentGateway {
    function payWithCreditCart(Payment $payment){
        return true;
    }
}