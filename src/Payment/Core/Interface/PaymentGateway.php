<?php

interface PaymentGateway {
    function payWithCreditCart(Payment $payment);
}