<?php
class UpdateLog extends TransactionLog {
    function __construct($table, $metadata) {
        parent::__construct( $table, TransactionOperation::$UPDATE, $metadata);
    }
    
}