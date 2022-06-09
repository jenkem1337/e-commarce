<?php 
require './vendor/autoload.php';
class UserDaoImpl implements UserDao{
    private DatabaseConnection $dbConnection;


    public function __construct(DatabaseConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    function findUserByEmail($email){
        $conn =  $this->dbConnection->getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->execute(['email'=>$email]);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        return $user;
        
    }
    function save(User $user){
        $conn =  $this->dbConnection->getConnection();
        
        $stmt = $conn->prepare("INSERT INTO users (uuid, full_name, email, user_password, email_activation_code, is_user_activated, user_role, created_at, updated_at) VALUES (:uuid, :full_name, :email, :user_password, :email_activation_code, :is_user_activated, :user_role, :created_at, :updated_at)");
        $stmt->execute([
            'uuid'=>$user->getUuid(),
            'full_name'=>$user->getFullname(),
            'email'=>$user->getEmail(),
            'user_password'=>$user->getPassword(),
            'email_activation_code'=>$user->getActivationCode(),
            'is_user_activated'=> $user->getIsUserActiveted(),
            'user_role'=>$user->getUserRole(),
            'created_at'=>$user->getCreatedAt(),
            'updated_at'=>$user->getCreatedAt()
        ]);
        $conn = null;
    }
    function findUserByActivationCode($code){
        $conn =  $this->dbConnection->getConnection();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email_activation_code=:email_activation_code");
        $stmt->execute(['email_activation_code'=>$code]);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);
        $conn = null;
        return $user;

    }
    function updateUserActivatedState(User $user){
        $conn = $this->dbConnection->getConnection();
        $stmt = $conn->prepare("UPDATE users SET is_user_activated=1, updated_at=NOW() WHERE email_activation_code=:code");
        $stmt->execute([
            'code'=>$user->getActivationCode()
        ]);
        $conn = null;
    }
}