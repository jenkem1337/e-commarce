<?php
abstract class TransactionLog {
    private $entityID;
    private $table;
    private $operation;
    private $data;
    private $whichWhereIdenty;

    function __construct($entityID, $table, $whichWhereIdenty, $operation, $data){
        $this->entityID = $entityID;
        $this->operation = $operation;
        $this->data = $data;
        $this->table = $table;
        $this->whichWhereIdenty = $whichWhereIdenty;
    }

    /**
     * Get the value of entityID
     */ 
    public function getEntityID()
    {
        return $this->entityID;
    }

    /**
     * Get the value of operation
     */ 
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Get the value of data
     */ 
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get the value of table
     */ 
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Get the value of whichWhereIdenty
     */ 
    public function getWhichWhereIdenty()
    {
        return $this->whichWhereIdenty;
    }
}