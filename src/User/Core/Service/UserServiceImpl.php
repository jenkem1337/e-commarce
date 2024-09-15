<?php

class UserServiceImpl implements UserService{
    private UserRepository $userRepository;
    function __construct(UserRepository $userRepo)
    {   
        $this->userRepository = $userRepo;
    }
    function changePassword(ChangePasswordDto $dto): ResponseViewModel
    {
        $user = $this->userRepository->findUserByEmail($dto->getEmail());
        $user->changePassword($dto->getOldPassword(), $dto->getNewPassword());
        $this->userRepository->updatePassword($user);
        return new PasswordChangeResponseDto(
            "Password changed successfuly"
        );
    }
    function changeForgettenPassword(ForgettenPasswordDto $forgettenPasswordDto): ResponseViewModel
    {
        $user = $this->userRepository->findUserByForgettenPasswordCode($forgettenPasswordDto->getVerificitationCode());
        if($user->isNull()) throw new NotMatchedException('verification code');
        $user->createNewPassword($forgettenPasswordDto->getNewPassword());
        $user->createForgettenPasswordCode();
        
        $this->userRepository->updatePassword($user);
        $this->userRepository->updateForgettenPasswordCode($user);

        return new ForgettenPasswordResponseDto(
            "Your password changed successfuly."
        );
    }

    function listAllUser(ListAllUserDto $listAllUserDto): ResponseViewModel
    {
        $userList = $this->userRepository->findAllWithPagination(
            $listAllUserDto->getStartingLimit(), 
            $listAllUserDto->getPerPageForUser(),
            new UserCollection()
        );
        return new AllUserResponseDto($userList->getIterator());
    }

    function findOneUserByUuid(FindOneUserByUuidDto $userUuidDto): ResponseViewModel
    {
        $user = $this->userRepository->findOneUserByUuid($userUuidDto->getUuid());
        if($user->isNull()) throw new DoesNotExistException('user');
        return new OneUserFoundedResponseDto(
            $user->getUuid(),
            $user->getFullname(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getUserRole(),
            $user->getIsUserActiveted(),
            $user->getCreatedAt(),
            $user->getUpdatedAt()
        );
    }

    function changeFullName(ChangeFullNameDto $changeFullNameDto): ResponseViewModel
    {
        $user = $this->userRepository->findUserByEmail($changeFullNameDto->getEmail());
        $user->changeFullName($changeFullNameDto->getNewFullname());

        $this->userRepository->updateFullName($user);
        return new FullNameChangedResponseDto(
            "Full name changed successfuly"
        );
    }
}