<?php
class InsertLog extends TransactionLog {
    function __construct($table, $metadata) {
        parent::__construct( $table,TransactionOperation::$INSERT, $metadata);
    }
}