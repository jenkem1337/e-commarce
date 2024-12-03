<?php

interface PaymentService {
    function pay(PayOrderDto $dto):ResponseViewModel;
    function refund(RefundPaymentDto $dto);
}