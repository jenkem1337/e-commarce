<?php

class PaymentRepositoryImpl extends TransactionalRepository implements PaymentRepository {
    private PaymentDao $paymentDao;

    function __construct(PaymentDao $paymentDao){
        $this->paymentDao = $paymentDao;
        parent::__construct($this->paymentDao);
    }

    function saveChanges(Payment $peyment){
        $this->paymentDao->saveChanges($peyment);
    }
}