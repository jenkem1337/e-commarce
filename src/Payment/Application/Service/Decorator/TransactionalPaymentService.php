<?php

class TransactionalPaymentService extends PaymentServiceDecorator {
    private TransactionalRepository $paymentRepository;

    function __construct(PaymentService $paymentService, TransactionalRepository $paymentRepo){
        $this->paymentRepository = $paymentRepo;
        parent::__construct($paymentService);
    }

    function payWithCreditCart(PayWithCreditCartDto $dto){
        try {
            $this->paymentRepository->beginTransaction();
            $response = parent::payWithCreditCart($dto);
            $this->paymentRepository->commit();
            return $response;
        } catch (\Exception $exception) {
            $this->paymentRepository->rollBack();
            throw $exception;
        }
    }
}