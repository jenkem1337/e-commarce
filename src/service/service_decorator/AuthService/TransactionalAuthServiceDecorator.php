<?php


require './vendor/autoload.php';

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

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            $dbConnection = null;
            return $response;
        }
    }
    function register(UserCreationalDto $userCreationalDto): ResponseViewModel
    {
        try {
            $dbConnection = $this->databaseConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::register($userCreationalDto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());

        } finally {
            $dbConnection = null;
            return $response;
        }
    }
    function verifyUserAccount(EmailVerificationDto $emailVerificationDto): ResponseViewModel
    {
        try {
            $dbConnection =  $this->databaseConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::verifyUserAccount($emailVerificationDto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());

        } finally {
            $dbConnection = null;
            return $response;
        }
    }
    function refreshToken(RefreshTokenDto $refDto): ResponseViewModel
    {
        try {
            $dbConnection =  $this->databaseConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response= parent::refreshToken($refDto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());

        } finally {
            $dbConnection = null;
            return $response;
        }
    }
    function sendChangeForgettenPasswordEmail(ForgettenPasswordEmailDto $forgettenPasswordMailDto): ResponseViewModel
    {
        try {
            $dbConnection =  $this->databaseConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response= parent::sendChangeForgettenPasswordEmail($forgettenPasswordMailDto);
            
            $dbConnection->commit();

        } catch (\Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());

        } finally {
            $dbConnection = null;
            return $response;
        }
    }
}