<?php
abstract class AbstractDataAccessObject {
    private DatabaseConnection $databaseConnection;
    function __construct($databaseConnection){
        $this->databaseConnection = $databaseConnection;
    }
    function saveChanges(BaseEntity $entity){
        $transactionLogs = $entity->getTransactionLogQueue();
        while(!$transactionLogs->isEmpty()) {
            $log = $transactionLogs->dequeue();
            
            switch($log->getOperation()) {
                case TransactionOperation::$INSERT:
                    $this->insertEntity($log->getTable(),$log->getData());
                    break;
                case TransactionOperation::$UPDATE:
                    $this->updateEntity($log->getTable(), $log->getEntityID(), $log->getWhichWhereIdenty(),$log->getData());
                    break;
                case TransactionOperation::$DELETE:
                    $this->deleteEntity($log->getTable(), $log->getEntityID(), $log->getWhichWhereIdenty());
                    break;
                default: throw new Exception("Unknown transaction log operation");
            }
        }
    }
    private function insertEntity($table, $metadata) {
        $columns = implode(", ", array_keys($metadata));
        
        $placeholders = implode(", ", array_fill(0, count($metadata), '?'));
        
        $conn = $this->databaseConnection->getConnection();
        
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        
        $stmt = $conn->prepare($sql);
        
        $stmt->execute(array_values($metadata));
    }

    
    private function updateEntity($table, $entityId, $whichWhereIdenty, $metadata) {
        $setClause = [];
        
        foreach ($metadata as $column => $value) {
            $setClause[] = "$column = ?";
        }
        
        $setClause = implode(", ", $setClause);
        
        $conn = $this->databaseConnection->getConnection();
        
        $sql = "UPDATE $table SET $setClause WHERE $whichWhereIdenty = ?";

        $stmt = $conn->prepare($sql);
        
        $stmt->execute(array_merge(array_values($metadata), [$entityId]));
    }

    
    private function deleteEntity($table,$entityId, $whichWhereIdenty) {
        $conn = $this->databaseConnection->getConnection();
        $sql = "DELETE FROM $table WHERE $whichWhereIdenty = ?";
        $stmt =$conn->prepare($sql);
        $stmt->execute([$entityId]);
    }

}