<?php
class DeleteLog extends TransactionLog {
    function __construct($entityID, $table, $data) {
        parent::__construct($entityID, $table, TransactionOperation::$DELETE, $data);
    }
}