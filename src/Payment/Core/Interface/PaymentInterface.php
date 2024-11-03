<?php
interface PaymentInterface {

    function getUserUuid() ;
    function getAmount() ;
    function getMethod() ;
    function getStatus() ;
    function getStrategy();
}