<?php

class NullOrder implements OrderInterface {
    function determineLatestAmount($shippingPrice){}
function setStateToProcessingAndAssignPaymentAndShippingUuid($paymentUuid, $shippingUuid){}
function setStatusToDelivered(){}
    public function getUserUuid(){}

    public function getPaymentUuid(){}

    public function getShippingUuid(){}

    public function getAmount(){}

    public function getStatus(): string {return OrderStatus::CANCELLED->value;}

    public function getItems(): OrderItemCollection{return new OrderItemCollection();}
    function isNull() {
        return true;
    }
}