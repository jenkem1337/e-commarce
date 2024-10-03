<?php
abstract class AbstractDataAccessObject {
    private $databaseInterface;
    private $tranactionConnection = null;
    function __construct($databaseInterface){
        $this->databaseInterface = $databaseInterface;
    }
    function startTransaction() {
        $this->tranactionConnection = $this->databaseInterface->getConnection();
        $this->tranactionConnection->beginTransaction();
    }
    function commitTransaction() {
        $this->tranactionConnection->commit();
        $this->tranactionConnection = null;
    }
    function rollbackTransaction(){
        $this->tranactionConnection->rollback();
        $this->tranactionConnection = null;
    }
    function saveChanges(BaseEntity $entity){
        $transactionLogs = $entity->getTransactionLogQueue();
        while(!$transactionLogs->isEmpty()) {
            $log = $transactionLogs->dequeue();
            
            switch($log->getOperation()) {
                case TransactionOperation::$INSERT:
                    $this->insertEntity($log->getTable(),$log->getMetadata());
                    break;
                case TransactionOperation::$UPDATE:
                    $this->updateEntity($log->getTable(), $log->getMetadata());
                    break;
                case TransactionOperation::$DELETE:
                    $this->deleteEntity($log->getTable(), $log->getMetadata());
                    break;
                default: throw new Exception("Unknown transaction log operation");
            }
        }
    }
    private function insertEntity($table, $metadata) {
        $columns = implode(", ", array_keys($metadata));
        
        $placeholders = implode(", ", array_fill(0, count($metadata), '?'));
        
        $conn = $this->databaseInterface->getConnection();
        
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        
        $stmt = $conn->prepare($sql);
        
        $stmt->execute(array_values($metadata));
    }

    
    private function updateEntity($table, $metadata) {
        $setClause = [];
        foreach ($metadata["setter"] as $column => $value) {
            $setClause[] = "$column = ?";
        }
        $setClause = implode(", ", $setClause);
    
        $whereClause = [];
        $values = array_values($metadata["setter"]);  
    
        foreach ($metadata["whereCondation"] as $column => $value) {
            $whereClause[] = "$column = ?";
            $values[] = $value;
        }
        $whereClauseString = implode( " AND ", $whereClause);
    
        $conn = $this->databaseInterface->getConnection();
        $sql = "UPDATE $table SET $setClause WHERE $whereClauseString";
        $stmt = $conn->prepare($sql);
    
        $stmt->execute($values);
    }
    
    
    private function deleteEntity($table, $metadata) {
        $conn = $this->databaseInterface->getConnection();
    
        $whereClause = [];
        $values = [];
    
        foreach ($metadata["whereCondation"] as $column => $value) {
            $whereClause[] = "$column = ?";
            $values[] = $value;
        }
    
        $whereClauseString = implode(" AND ", $whereClause);
        $sql = "DELETE FROM $table WHERE $whereClauseString";
    
        $stmt = $conn->prepare($sql);
        $stmt->execute($values);
    }
}