<?php

use phpDocumentor\Reflection\Types\Boolean;

interface OrderInterface extends BaseEntityInterface{
    function determineLatestAmount($shippingPrice);
    function setStateToProcessingAndAssignPaymentAndShippingUuid($paymentUuid, $shippingUuid);
    function setStatusToDelivered();
    function setStatusToDispatched();
    public function getUserUuid();

    public function getPaymentUuid();

    public function getShippingUuid();

    public function getAmount();

    public function getStatus(): string;

    public function getItems(): OrderItemCollection;
    
}