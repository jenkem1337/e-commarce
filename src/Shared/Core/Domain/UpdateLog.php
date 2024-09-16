<?php
class UpdateLog extends TransactionLog {
    function __construct($entityID, $table, $data) {
        parent::__construct($entityID, $table, TransactionOperation::$UPDATE, $data);
    }
    function getTable(){
        return parent::getTable();
    }
}