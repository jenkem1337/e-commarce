<?php
interface PaymentRepository {
    function saveChanges(Payment $peyment);
    function findOneAggregateByUuid($uuid):PaymentInterface;
}