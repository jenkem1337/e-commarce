<?php

class OrderDaoImpl extends AbstractDataAccessObject implements OrderDao{
    private DatabaseConnection $databaseConnection;
    function __construct($databaseInterface) {
        $this->databaseConnection = $databaseInterface;
        parent::__construct($this->databaseConnection);
    }
    
}