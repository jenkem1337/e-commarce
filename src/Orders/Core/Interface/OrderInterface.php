<?php

interface OrderInterface{
    function determineLatestAmount($shippingPrice);
    function setStateToProcessingAndAssignPaymentAndShippingUuid($paymentUuid, $shippingUuid);
    function setStatusToDelivered();
    public function getUserUuid();

    public function getPaymentUuid();

    public function getShippingUuid();

    public function getAmount();

    public function getStatus(): string;

    public function getItems(): OrderItemCollection;
}