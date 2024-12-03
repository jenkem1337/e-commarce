<?php

interface PaymentGateway {
    function payWithCreditCart(Payment $payment);
    function refund(Payment $payment);
}