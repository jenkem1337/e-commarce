<?php
class DeleteLog extends TransactionLog {
    function __construct($table, $metadata) {
        parent::__construct($table,TransactionOperation::$DELETE, $metadata);
    }
}