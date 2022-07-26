<?php
require './vendor/autoload.php';
class TransactionalUserServiceDecorator extends UserServiceDecorator {
    private DatabaseConnection $databaseConnection;
    function __construct(UserService $service, DatabaseConnection $databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
        parent::__construct($service);
    }
    function changePassword(ChangePasswordDto $dto):ResponseViewModel {
        try {
            $dbConnection =  $this->databaseConnection->getConnection();

            $dbConnection->beginTransaction();
            
            $response = parent::changePassword($dto);
            
            $dbConnection->commit();
        } catch (\Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        }finally {
            $dbConnection = null;
            return $response;
        }
    }
    function changeForgettenPassword(ForgettenPasswordDto $forgettenPasswordDto):ResponseViewModel{
        try {
            $dbConnection =  $this->databaseConnection->getConnection();

            $dbConnection->beginTransaction();
            
            $response = parent::changeForgettenPassword($forgettenPasswordDto);
            
            $dbConnection->commit();
        } catch (\Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        }finally {
            $dbConnection = null;
            return $response;
        }

    }
    function listAllUser(ListAllUserDto $listAllUserDto):ResponseViewModel {
        return parent::listAllUser($listAllUserDto);
    }
    function findOneUserByUuid(FindOneUserByUuidDto $userUuidDto):ResponseViewModel{
        try {
            $dbConnection =  $this->databaseConnection->getConnection();

            $dbConnection->beginTransaction();
            
            $response = parent::findOneUserByUuid($userUuidDto);
            
            $dbConnection->commit();
        } catch (\Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        }finally {
            $dbConnection = null;
            return $response;
        }

    }
    function changeFullName(ChangeFullNameDto $changeFullNameDto):ResponseViewModel{
        try {
            $dbConnection = $this->databaseConnection->getConnection();

            $dbConnection->beginTransaction();
            
            $response = parent::changeFullName($changeFullNameDto);
            
            $dbConnection->commit();
        } catch (\Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        }finally {
            $dbConnection = null;
            return $response;
        }

    }

}