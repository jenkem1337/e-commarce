<?php

interface UserService {
    function changePassword(ChangePasswordDto $dto):ResponseViewModel;
    function changeForgettenPassword(ForgettenPasswordDto $forgettenPasswordDto):ResponseViewModel;
    function listAllUser(ListAllUserDto $listAllUserDto):ResponseViewModel;
    function findOneUserByUuid(FindOneUserByUuidDto $userUuidDto):ResponseViewModel;
    function changeFullName(ChangeFullNameDto $changeFullNameDto):ResponseViewModel;
}