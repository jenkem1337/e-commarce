<?php
require './vendor/autoload.php';
abstract class UserServiceDecorator implements UserService {
    private UserService $service;
    function __construct(UserService $service)
    {
        $this->service = $service;
    }
    function changePassword(ChangePasswordDto $dto):ResponseViewModel {
        return $this->service->changePassword($dto);
    }
    function changeForgettenPassword(ForgettenPasswordDto $forgettenPasswordDto):ResponseViewModel{
        return $this->service->changeForgettenPassword($forgettenPasswordDto);
    }
    function listAllUser(ListAllUserDto $listAllUserDto):ResponseViewModel{
        return $this->service->listAllUser($listAllUserDto);
    }
    function findOneUserByUuid(FindOneUserByUuidDto $userUuidDto):ResponseViewModel{
        return $this->findOneUserByUuid($userUuidDto);
    }
    function changeFullName(ChangeFullNameDto $changeFullNameDto):ResponseViewModel{
        return $this->service->changeFullName($changeFullNameDto);
    }

}