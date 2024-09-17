<?php
class UpdateLog extends TransactionLog {
    function __construct($entityID, $table, $whichWhereIdenty, $data) {
        parent::__construct($entityID, $table, $whichWhereIdenty,TransactionOperation::$UPDATE, $data);
    }
    
}