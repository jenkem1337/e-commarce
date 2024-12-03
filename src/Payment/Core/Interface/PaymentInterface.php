<?php
interface PaymentInterface extends BaseEntityInterface {
    function setStatusToCompleted();
    function setStatusToRefunded();
    function setStatusToFailed();
    function getUserUuid() ;
    function getAmount() ;
    function getMethod() ;
    function getStatus() ;
    function getStrategy();
}