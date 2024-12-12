<?php

class NullOrder implements OrderInterface {
    function determineLatestAmount($shippingPrice){}
    function setStatusToReturned(){}
    function setStatusToCanceled(){}
    function setStatusToReturnRequest(){}
    function setStateToProcessingAndAssignPaymentAndShippingUuid($paymentUuid, $shippingUuid){}
    function setStatusToDelivered(){}
    function setStatusToDispatched(){}
    public function getUserUuid(){}

    public function getPaymentUuid(){}

    public function getShippingUuid(){}

    public function getAmount(){}

    public function getStatus(): string {return OrderStatus::CANCELLED->value;}

    public function getItems(): OrderItemCollection{return new OrderItemCollection();}

    function getCreatedAt(){}
    function getUpdatedAt(){}
    function getUuid(){}
    function isNull(): bool {
        return true;
    }
}