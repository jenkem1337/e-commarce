<?php

interface PaymentService {
    function payWithCreditCart(CreationalPaymentDto $dto);
}