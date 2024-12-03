<?php
class FakePaymentGatewayImpl implements PaymentGateway {
    function payWithCreditCart(Payment $payment){
        return true;
    }

    function refund(Payment $payment){
        return true;
    }
}