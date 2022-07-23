<?php


require './vendor/autoload.php';

class TransactionalAuthServiceDecorator extends AuthServiceDecorator {
    function __construct(AuthService $service)
    {
        parent::__construct($service);
    }
    function login(UserLoginDto $userLoginDto): ResponseViewModel
    {                                                   
        try {
            $db = MySqlPDOConnection::getInsatace();
            $dbConnection = $db->getConnection();
            
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
            $db = MySqlPDOConnection::getInsatace();
            $dbConnection = $db->getConnection();
            
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
            $db = MySqlPDOConnection::getInsatace();
            $dbConnection = $db->getConnection();
            
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
            $db = MySqlPDOConnection::getInsatace();
            $dbConnection = $db->getConnection();
            
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
            $db = MySqlPDOConnection::getInsatace();
            $dbConnection = $db->getConnection();
            
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