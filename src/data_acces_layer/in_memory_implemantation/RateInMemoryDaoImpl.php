<?php


class RateInMemoryDaoImpl extends RateDaoImpl{
    
    function __construct(SingletonConnection $conn)
    {
        parent::__construct($conn);
        $this->createProductTable();
        $this->createUserTable();
        $this->createRateTable();
    }
    private function createRateTable(){
        $this->dbConnection->getConnection()
                        ->exec(
                            "CREATE TABLE IF NOT EXISTS rates (
                                uuid text,
                                rate_num integer,
                                product_uuid text,
                                user_uuid text,
                                created_at datetime,
                                updated_at datetime,
                                foreign key (product_uuid)
                                    references products(uuid)
                                    on delete cascade
                                    on update cascade
                                foreign key (user_uuid)
                                    references products(uuid)
                                    on delete cascade
                                    on update cascade
                            )"
                        );
        }
        private function createUserTable(){
                            $this->dbConnection->getConnection()
                                                ->exec("CREATE TABLE IF NOT EXISTS users (
                                                        uuid TEXT PRIMARY KEY,
                                                        full_name TEXT,
                                                        email TEXT,
                                                        user_password  TEXT,
                                                        email_activation_code	TEXT,
                                                        forgetten_password_activation_code TEXT,
                                                        is_user_activated BOOLEAN,
                                                        user_role TEXT,
                                                        created_at DATETIME,
                                                        updated_at DATETIME)");
                    
                        }
        private function createProductTable(){
                            $this->dbConnection->getConnection()
                            ->exec("CREATE TABLE IF NOT EXISTS products (
                                uuid TEXT PRIMARY KEY,
                                brand TEXT,
                                model TEXT,
                                header TEXT,
                                _description TEXT,
                                price FLOAT,
                                prev_price FLOAT,
                                rate FLOAT,
                                stokquantity INTEGER,
                    
                                created_at DATETIME,
                    
                                updated_at DATETIME)");
                    
    }
    function updateRateNumberByUuid(Rate $r) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "UPDATE rates SET rate_num = :rate_num, updated_at = DATE('now')
            WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$r->getUuid(),
            'rate_num'=>$r->getRateNumber()
        ]);
        $conn = null;
	}

}