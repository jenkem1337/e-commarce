<?php

interface UserService {
    function changePassword(ChangePasswordDto $dto):PasswordChangeResponseDto;
    function changeForgettenPassword(ForgettenPasswordDto $forgettenPasswordDto):ForgettenPasswordResponseDto;
    function listAllUser(ListAllUserDto $listAllUserDto):array;
    function findOneUserByUuid(FindOneUserByUuidDto $userUuidDto):OneUserFoundedResponseDto;
    function changeFullName(ChangeFullNameDto $changeFullNameDto):FullNameChangedResponseDto;
}