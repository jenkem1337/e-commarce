<?php
class NullPayment implements PaymentInterface, NullEntityInterface {
    function setStatusToFailed(){}
    function setStatusToCompleted(){}
    function setStatusToRefunded() {}
    function getUserUuid() {}
    function getAmount() {}
    function getMethod() {}
    function getStatus() {}
    function getCreatedAt(){}
    function getUpdatedAt() {}
    function getUuid(){}
    function getStrategy(){}
    function isNull(): bool{
        return true;
    }
}