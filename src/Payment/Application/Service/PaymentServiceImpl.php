<?php

class PaymentServiceImpl implements PaymentService {
    function __construct(
        private PaymentRepository $paymentRepository,
        private PaymentGateway $paymentGateway,
    ){}
    private function payWithCreditCart(PayWithCreditCartDto $dto):ResponseViewModel{
        $payment = Payment::payWithCreditCart(
            $dto->getUserUuid(),
            $dto->getAmount(),
            $dto->getCartNumber(),
            $dto->getCartExpirationDate(),
            $dto->getCartCVC(),
            $dto->getCartOwner() 
        );
        
        $this->paymentGateway->payWithCreditCart($payment);

        $payment->setStatusToCompleted();

        $this->paymentRepository->saveChanges($payment);
        return new SuccessResponse([
            "data" => [
                "uuid" => $payment->getUuid()
            ]
        ]);
    }

    function pay(PayOrderDto $dto): ResponseViewModel {
        $response = null;
        switch($dto->getPaymentMethod()){
            case "CreditCart":
                $response = $this->payWithCreditCart(new PayWithCreditCartDto($dto->getUserUuid(), $dto->getPaymentMethod(), $dto->getOrderAmount(), $dto->getPaymentDetail()->number, $dto->getPaymentDetail()->expiration_date, $dto->getPaymentDetail()->cvc, $dto->getPaymentDetail()->owner));
                break;
            default: throw new Exception("Unknown payment command");
        }
        return $response;
    }

    function refund(RefundPaymentDto $refundPaymentDto){
        $paymentAggregate = $this->paymentRepository->findOneAggregateByUuid($refundPaymentDto->getUuid());
        if ($paymentAggregate->isNull()) throw new NotFoundException("payment");

        $this->paymentGateway->refund($paymentAggregate);

        $paymentAggregate->setStatusToRefunded();

        $this->paymentRepository->saveChanges($paymentAggregate);

    }
}