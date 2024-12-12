<?php

interface OrderInterface extends BaseEntityInterface{
    function determineLatestAmount($shippingPrice);
    function setStateToProcessingAndAssignPaymentAndShippingUuid($paymentUuid, $shippingUuid);
    function setStatusToDelivered();
    function setStatusToReturned();
    function setStatusToDispatched();
    function setStatusToCanceled();
    function setStatusToReturnRequest();
    public function getUserUuid();

    public function getPaymentUuid();

    public function getShippingUuid();

    public function getAmount();

    public function getStatus(): string;

    public function getItems(): OrderItemCollection;
    
}