<?php
class DeleteLog extends TransactionLog {
    function __construct($entityID, $table, $whichWhereIdenty, $data) {
        parent::__construct($entityID, $table, $whichWhereIdenty,TransactionOperation::$DELETE, $data);
    }
}