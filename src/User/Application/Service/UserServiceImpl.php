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
        return new SuccessResponse([
            "message" => "Password changed successfuly"
        ]);
    }
    function changeForgettenPassword(ForgettenPasswordDto $forgettenPasswordDto): ResponseViewModel
    {
        $user = $this->userRepository->findUserByForgettenPasswordCode($forgettenPasswordDto->getVerificitationCode());
        if($user->isNull()) throw new NotMatchedException('verification code');
        $user->createNewPassword($forgettenPasswordDto->getNewPassword());
        $user->createForgettenPasswordCode();
        
        $this->userRepository->updatePassword($user);
        $this->userRepository->updateForgettenPasswordCode($user);

        return new SuccessResponse([
            "message" => "Password changed successfuly"
        ]);
    }

    function listAllUser(ListAllUserDto $listAllUserDto): ResponseViewModel
    {
        $userList = $this->userRepository->findAllWithPagination(
            $listAllUserDto->getStartingLimit(), 
            $listAllUserDto->getPerPageForUser(),
        );
        return new SuccessResponse(["data"=>$userList]);
    }

    function findOneUserByUuid(FindOneUserByUuidDto $userUuidDto): ResponseViewModel
    {
        $user = $this->userRepository->findOneUserByUuid($userUuidDto->getUuid());
        if($user->isNull()) throw new DoesNotExistException('user');
        return new SuccessResponse([
            "data" => [
                "uuid" => $user->getUuid(),
                "full_name" => $user->getFullname(),
                "email" => $user->getEmail(),
                "password" => $user->getPassword(),
                "user_role" => $user->getUserRole(),
                "is_user_activeted" => $user->getIsUserActiveted(),
                "created_at" => $user->getCreatedAt(),
                "updated_at" => $user->getUpdatedAt()
            ]
        ]);
    }

    function changeFullName(ChangeFullNameDto $changeFullNameDto): ResponseViewModel
    {
        $user = $this->userRepository->findUserByEmail($changeFullNameDto->getEmail());
        $user->changeFullName($changeFullNameDto->getNewFullname());

        $this->userRepository->updateFullName($user);
        return new SuccessResponse([
            "message" => "Full name changed successfuly",
            "data" => ["full_name" => $user->getFullname()]
        ]);
    }
}