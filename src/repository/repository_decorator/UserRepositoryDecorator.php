<?php
require "./vendor/autoload.php";
class UserRepositoryDecorator implements UserRepository {
    private UserRepository $userRepository;
    function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }
    function findUserByEmail($userMail):UserInterface{
        return $this->userRepository->findUserByEmail($userMail);
    }
    function persistUser(User $user){
        $this->userRepository->persistUser($user);
    }
    function findUserByVerificationCode($code):UserInterface{
        return $this->userRepository->findUserByVerificationCode($code);
    }
    function updateUserActivatedState(User $user){
        $this->userRepository->updateUserActivatedState($user);
    }
    function persistRefreshToken(User $user){
        $this->userRepository->persistRefreshToken($user);
    }
    function findUserByUuidWithRefreshToken($refreshToken):UserInterface{
        return $this->userRepository->findUserByUuidWithRefreshToken($refreshToken);
    }
    function updatePassword(User $user){
        $this->userRepository->updatePassword($user);
    }
    function updateForgettenPasswordCode(User $user){
        $this->userRepository->updateForgettenPasswordCode($user);
    }
    function findUserByForgettenPasswordCode($passwordCode):UserInterface{
        return $this->userRepository->findUserByForgettenPasswordCode($passwordCode);
    }
    function findAllWithPagination($startingLimit, $perPageForUsers):array{
        return $this->userRepository->findAllWithPagination($startingLimit, $perPageForUsers);
    }
    function findOneUserByUuid($uuid):UserInterface{
        return $this->userRepository->findOneUserByUuid($uuid);
    }
    function updateFullName(User $user){
        $this->userRepository->updateFullName($user);
    }

}