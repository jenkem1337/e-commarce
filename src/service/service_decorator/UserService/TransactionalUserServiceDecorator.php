<?php
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
            $this->databaseConnection->closeConnection();

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
            $this->databaseConnection->closeConnection();

            $dbConnection = null;
            return $response;
        }

    }
    function listAllUser(ListAllUserDto $listAllUserDto):ResponseViewModel {
        $response =  parent::listAllUser($listAllUserDto);
        $this->databaseConnection->closeConnection();
        return $response;
    }
    function findOneUserByUuid(FindOneUserByUuidDto $userUuidDto):ResponseViewModel{
            $response = parent::findOneUserByUuid($userUuidDto);
            
            $this->databaseConnection->closeConnection();

            return $response;
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
            $this->databaseConnection->closeConnection();

            $dbConnection = null;
            return $response;
        }

    }

}