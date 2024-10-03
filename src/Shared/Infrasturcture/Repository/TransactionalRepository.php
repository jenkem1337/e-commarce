<?php

abstract class TransactionalRepository {
    private $dataAccessObject;
    function __construct($dataAccessObject){
        $this->dataAccessObject = $dataAccessObject;
    }
    function beginTransaction() {
        $this->dataAccessObject->startTransaction();
    }
    function commit() {
        $this->dataAccessObject->commitTransaction();
    }
    function rollBack(){
        $this->dataAccessObject->rollbackTransaction();
    }

}