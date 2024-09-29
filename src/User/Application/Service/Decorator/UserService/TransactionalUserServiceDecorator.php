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
            return $response;

        } catch (\Exception $e) {
            $dbConnection->rollBack();
            throw $e;
        }
    }
    function changeForgettenPassword(ForgettenPasswordDto $forgettenPasswordDto):ResponseViewModel{
        try {
            $dbConnection =  $this->databaseConnection->getConnection();

            $dbConnection->beginTransaction();
            
            $response = parent::changeForgettenPassword($forgettenPasswordDto);
            
            $dbConnection->commit();
            return $response;

        } catch (\Exception $e) {
            $dbConnection->rollBack();
            throw $e;
        }

    }
    function listAllUser(ListAllUserDto $listAllUserDto):ResponseViewModel {
        $response =  parent::listAllUser($listAllUserDto);
        return $response;
    }
    function findOneUserByUuid(FindOneUserByUuidDto $userUuidDto):ResponseViewModel{
            $response = parent::findOneUserByUuid($userUuidDto);
            return $response;
    }
    function changeFullName(ChangeFullNameDto $changeFullNameDto):ResponseViewModel{
        try {
            $dbConnection = $this->databaseConnection->getConnection();

            $dbConnection->beginTransaction();
            
            $response = parent::changeFullName($changeFullNameDto);
            
            $dbConnection->commit();
            return $response;

        } catch (\Exception $e) {
            $dbConnection->rollBack();
            throw $e;
        }

    }

}