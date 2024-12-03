<?php

class PaymentRepositoryImpl extends TransactionalRepository implements PaymentRepository {
    private PaymentDao $paymentDao;

    function __construct(PaymentDao $paymentDao){
        $this->paymentDao = $paymentDao;
        parent::__construct($this->paymentDao);
    }

    function saveChanges(Payment $payment){
        $this->paymentDao->saveChanges($payment);
    }

    function findOneAggregateByUuid($uuid): PaymentInterface {
        $paymentObject = $this->paymentDao->findOneByUuid($uuid);

        return Payment::newInstance(
            $paymentObject->uuid,
            $paymentObject->user_uuid,
            $paymentObject->amount,
            $paymentObject->method,
            $paymentObject->status,
            $paymentObject->created_at,
            $paymentObject->updated_at
        );
    }
}