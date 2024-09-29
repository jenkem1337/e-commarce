<?php



class TransactionalAuthServiceDecorator extends AuthServiceDecorator {
    private DatabaseConnection $databaseConnection;
    function __construct(AuthService $service, DatabaseConnection $databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
        parent::__construct($service);
    }
    function login(UserLoginDto $userLoginDto): ResponseViewModel
    {                                                   
        try {
            $dbConnection =  $this->databaseConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::login($userLoginDto);
            
            $dbConnection->commit();
            return $response;

        } catch (Exception $e) {
            $dbConnection->rollBack();
            throw $e;
        } 
    }
    function register(UserCreationalDto $userCreationalDto): ResponseViewModel
    {
        try {
            $dbConnection = $this->databaseConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::register($userCreationalDto);
            
            $dbConnection->commit();
            return $response;

        } catch (Exception $e) {
            $dbConnection->rollBack();
            throw $e;
        }
    }
    function verifyUserAccount(EmailVerificationDto $emailVerificationDto): ResponseViewModel
    {
        try {
            $dbConnection =  $this->databaseConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::verifyUserAccount($emailVerificationDto);
            
            $dbConnection->commit();
            return $response;

        } catch (Exception $e) {
            $dbConnection->rollBack();
            throw $e;
        } 
    }
    function refreshToken(RefreshTokenDto $refDto): ResponseViewModel
    {
        try {
            $dbConnection =  $this->databaseConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response= parent::refreshToken($refDto);
            
            $dbConnection->commit();
            return $response;

        } catch (Exception $e) {
            $dbConnection->rollBack();
            throw $e;
        } 
    }
    function sendChangeForgettenPasswordEmail(ForgettenPasswordEmailDto $forgettenPasswordMailDto): ResponseViewModel
    {
        try {
            $dbConnection =  $this->databaseConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response= parent::sendChangeForgettenPasswordEmail($forgettenPasswordMailDto);
            
            $dbConnection->commit();
            return $response;

        } catch (\Exception $e) {
            $dbConnection->rollBack();
            throw $e;
        } 
    }
}