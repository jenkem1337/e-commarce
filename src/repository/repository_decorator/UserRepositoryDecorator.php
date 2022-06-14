<?php
require "./vendor/autoload.php";
class UserRepositoryDecorator implements UserRepository {
    private UserRepository $userRepository;
    function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }
    function findUserByEmail($userId){
        return $this->userRepository->findUserByEmail($userId);
    }
    function save(User $user){
        $this->userRepository->save($user);
    }
    function findUserByVerificationCode($code){
        return $this->userRepository->findUserByVerificationCode($code);
    }
    function updateUserActivatedState(User $user){
        $this->userRepository->updateUserActivatedState($user);
    }
    function saveRefreshToken(User $user){
        $this->userRepository->saveRefreshToken($user);
    }
    function findUserByUuidWithRefreshToken($refreshToken){
        return $this->userRepository->findUserByUuidWithRefreshToken($refreshToken);
    }
    function updatePassword(User $user){
        $this->userRepository->updatePassword($user);
    }
    function updateForgettenPasswordCode(User $user){
        $this->userRepository->updateForgettenPasswordCode($user);
    }
    function findUserByForgettenPasswordCode($passwordCode){
        return $this->userRepository->findUserByForgettenPasswordCode($passwordCode);
    }
    function findAllWithPagination($startingLimit, $perPageForUsers){
        return $this->userRepository->findAllWithPagination($startingLimit, $perPageForUsers);
    }
    function findOneUserByUuid($uuid){
        return $this->userRepository->findOneUserByUuid($uuid);
    }
    function updateFullName(User $user){
        $this->userRepository->updateFullName($user);
    }

}