<?php
require './vendor/autoload.php';
class CommentInMemoryDaoImpl extends CommentDaoImpl{
    function __construct(SingletonConnection $conn)
    {
        parent::__construct($conn);
        
        $this->createUserTable();
        $this->createProductTable();
        $this->createCommentTable();
    }
    private function createCommentTable(){
        $this->dbConnection->getConnection()
                            ->exec("CREATE TABLE IF NOT EXISTS comment (
                                uuid TEXT PRIMARY KEY,
                                comment_text TEXT,
                                user_uuid TEXT,
                                product_uuid TEXT,
                                created_at DATETIME,
                                updated_at DATETIME,

                                FOREIGN KEY (user_uuid) 
                                    REFERENCES users(uuid) 
                                    ON DELETE CASCADE
                                    ON UPDATE CASCADE
                                FOREIGN KEY (product_uuid)
                                    REFERENCES products(uuid)
                                    ON DELETE CASCADE
                                    ON UPDATE CASCADE)");
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
    function updateByUuid(Comment $c) {
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare(
            "UPDATE comment SET comment_text = :comment_text, updated_at = DATE('now') WHERE uuid = :uuid"
        );
        $stmt->execute([
            'uuid'=>$c->getUuid(),
            'comment_text'=>$c->getComment()
        ]);
        $conn = null;
	}

}