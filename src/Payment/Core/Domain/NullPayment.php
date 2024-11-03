<?php
class NullPayment implements PaymentInterface, NullEntityInterface {
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