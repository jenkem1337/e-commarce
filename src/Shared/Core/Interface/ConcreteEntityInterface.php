<?php
interface ConcreteEntityInterface extends BaseEntityInterface {
    function appendLog(TransactionLog $transactionLog);
    function getTransactionLogQueue(): SplQueue;
}