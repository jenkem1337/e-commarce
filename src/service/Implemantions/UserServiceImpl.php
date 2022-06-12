<?php
require "./vendor/autoload.php";

class UserServiceImpl implements UserService{
    private UserRepository $userRepository;
    function __construct(UserRepository $userRepo)
    {   
        $this->userRepository = $userRepo;
    }
    function changePassword(ChangePasswordDto $dto): PasswordChangeResponseDto
    {
        $user = $this->userRepository->findUserByEmail($dto->getEmail());
        $user->changePassword($dto->getOldPassword(), $dto->getNewPassword());
        $this->userRepository->updatePassword($user);
        return new PasswordChangeResponseDto(
            true,
            "Password changed successfuly"
        );
    }
    function changeForgettenPassword(ForgettenPasswordDto $forgettenPasswordDto): ForgettenPasswordResponseDto
    {
        $user = $this->userRepository->findUserByForgettenPasswordCode($forgettenPasswordDto->getVerificitationCode());
        if(!$user) throw new Exception('Verification code is not matched');
        $user->createNewPassword($forgettenPasswordDto->getNewPassword());
        $user->createForgettenPasswordCode();
        
        $this->userRepository->updatePassword($user);
        $this->userRepository->updateForgettenPasswordCode($user);

        return new ForgettenPasswordResponseDto(
            true,
            "Your password changed successfuly."
        );
    }

    function listAllUser(ListAllUserDto $listAllUserDto): array
    {
        $userList = $this->userRepository->findAllWithPagination($listAllUserDto->getStartingLimit(), $listAllUserDto->getPerPageForUser());
        $usersResponseList = array();
        foreach($userList as $user){
            $usersResponseList[] = new AllUserResponseDto(
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
        return $usersResponseList;
    }

    function findOneUserByUuid(FindOneUserByUuidDto $userUuidDto): OneUserFoundedResponseDto
    {
        $user = $this->userRepository->findOneUserByUuid($userUuidDto->getUuid());
        if(!$user) throw new Exception('user doesnt exist in database');
        return new OneUserFoundedResponseDto(
            true,
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

    function changeFullName(ChangeFullNameDto $changeFullNameDto): FullNameChangedResponseDto
    {
        $user = $this->userRepository->findUserByEmail($changeFullNameDto->getEmail());
        $user->changeFullName($changeFullNameDto->getNewFullname());

        $this->userRepository->updateFullName($user);
        return new FullNameChangedResponseDto(
            true,
            "Full name changed successfuly"
        );
    }
}