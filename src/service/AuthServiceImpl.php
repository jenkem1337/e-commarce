<?php
require './vendor/autoload.php';

class AuthServiceImpl implements AuthService{
    private UserRepository $userRepository;
    private EmailService $emailService;

    function __construct(UserRepository $userRepo, EmailService $emailService)
    {
        $this->userRepository = $userRepo;
        $this->emailService = $emailService;
    }
    function login(UserLoginDto $userLoginDto){

    }
    
    function register(UserCreationalDto $userCreationalDto){
        $user = new User(
            $userCreationalDto->getUuid(),
            $userCreationalDto->getFullname(),
            $userCreationalDto->getEmail(),
            $userCreationalDto->getPassword(),
            $userCreationalDto->getIsUserActivaed(),
            $userCreationalDto->getCreated_at(),
            $userCreationalDto->getUpdated_at()
        );

        $isUserAlredyExist = $this->userRepository->findUserByEmail($user->getEmail());
        
        if($isUserAlredyExist){
            throw new Exception('this user alredey exist');
        }

        $user->hashPassword($user->getPassword());
        $user->createActivationCode();

        $this->userRepository->save($user);
        $this->emailService->sendVerificationCode($user);

        return new UserCreatedResponseDto(
            true,
            $userCreationalDto->getUuid(),
            $userCreationalDto->getFullname(),
            $userCreationalDto->getEmail(),
            $userCreationalDto->getIsUserActivaed(),
            $userCreationalDto->getCreated_at(),
            $userCreationalDto->getUpdated_at()
        );

    }

    function verifyUserAccount(EmailVerificationDto $emailVerificationDto){
        $user = $this->userRepository->findUserByVerificationCode($emailVerificationDto->getCode());
        if(!$user){
            throw new Exception('this user doesnt exist in database');
        }

        $this->userRepository->updateUserActivatedState($user);

        $updatedUser = $this->userRepository->findUserByEmail($user->getEmail());
        return new EmailSuccessfulyActivatedResponseDto(
            true,
            $updatedUser->getUuid(),
            $updatedUser->getFullname(),
            $updatedUser->getEmail(),
            $updatedUser->getIsUserActiveted(),
            $updatedUser->getCreatedAt(),
            $updatedUser->getUpdatedAt()

        );


    }
}
