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
                    $this->updateEntity($log->getTable(), $log->getEntityID(), $log->getData());
                    break;
                case TransactionOperation::$DELETE:
                    $this->deleteEntity($log->getTable(), $log->getEntityID());
                    break;
                default: throw new Exception("Unknown transaction log operation");
            }
        }
    }
    protected function insertEntity($table, $metadata) {
        $columns = implode(", ", array_keys($metadata));
        
        $placeholders = implode(", ", array_fill(0, count($metadata), '?'));
        
        $conn = $this->databaseConnection->getConnection();
        
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        
        $stmt = $conn->prepare($sql);
        
        $stmt->execute(array_values($metadata));
    }

    // UPDATE sorgusu oluşturur ve veritabanında günceller
    protected function updateEntity($table, $entityId, $metadata) {
        $setClause = [];
        
        foreach ($metadata as $column => $value) {
            $setClause[] = "$column = ?";
        }
        
        $setClause = implode(", ", $setClause);
        
        $conn = $this->databaseConnection->getConnection();
        
        $sql = "UPDATE $table SET $setClause WHERE uuid = ?";
        
        $stmt = $conn->prepare($sql);
        
        $stmt->execute(array_merge(array_values($metadata), [$entityId]));
    }

    // DELETE sorgusu oluşturur ve veritabanından siler
    protected function deleteEntity($table,$entityId) {
        $conn = $this->databaseConnection->getConnection();
        $sql = "DELETE FROM $table WHERE uuid = ?";
        $stmt =$conn->prepare($sql);
        $stmt->execute([$entityId]);
    }

}