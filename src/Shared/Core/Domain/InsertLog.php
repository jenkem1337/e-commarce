<?php
class InsertLog extends TransactionLog {
    function __construct($entityID, $table, $whichWhereIdenty,$data) {
        parent::__construct($entityID, $table, $whichWhereIdenty,TransactionOperation::$INSERT, $data);
    }
}