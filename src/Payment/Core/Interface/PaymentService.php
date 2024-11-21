<?php

interface PaymentService {
    function pay(PayOrderDto $dto):ResponseViewModel;
}