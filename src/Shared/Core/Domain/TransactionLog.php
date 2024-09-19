<?php
abstract class TransactionLog {
    private $table;
    private $operation;
    private $metadata;

    function __construct($table, $operation, $data){
        $this->operation = $operation;
        $this->metadata = $data;
        $this->table = $table;
    }

    public function getOperation()
    {
        return $this->operation;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }
    public function getTable()
    {
        return $this->table;
    }
}