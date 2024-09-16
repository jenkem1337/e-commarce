<?php
class InsertLog extends TransactionLog {
    function __construct($entityID, $table, $data) {
        parent::__construct($entityID, $table, TransactionOperation::$INSERT, $data);
    }
}