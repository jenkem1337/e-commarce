<?php
require './vendor/autoload.php';
use Ramsey\Uuid\Nonstandard\Uuid;

class AuthServiceImpl implements AuthService{
    private UserRepository $userRepository;
    private EmailService $emailService;

    function __construct(UserRepository $userRepo, EmailService $emailService)
    {
        $this->userRepository = $userRepo;
        $this->emailService   = $emailService;
    }
    function login(UserLoginDto $userLoginDto):UserLogedInResponseDto{
        $user = $this->userRepository->findUserByEmail($userLoginDto->getEmail());
        if(!$user){
            throw new Exception('this user doesnt exist in database');
        }

        $refreshToken = new RefreshToken(Uuid::uuid4(),$user->getUuid(), date('Y-m-d H:i:s'),date('Y-m-d H:i:s'));
        $refreshToken->createRefreshToken(60*60*24*10);

        $user->setRefreshTokenModel($refreshToken);

        $this->userRepository->saveRefreshToken($user);

        $user->comparePassword($userLoginDto->getPassword());
        $user->isUserActiveted();

        return new UserLogedInResponseDto(
            true,
            $user->getUuid(),
            $user->getFullname(),
            $user->getEmail(),
            $user->getUserRole(),
            $user->getRefreshTokenModel()
        );

    }
    
    function register(UserCreationalDto $userCreationalDto):UserCreatedResponseDto{
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


    function refreshToken(RefreshTokenDto $refreshTokenDto):RefreshTokenResponseDto{
        $userWithRefreshTokenModel = $this->userRepository->findUserByUuidWithRefreshToken(
            $refreshTokenDto->getRefreshToken()
        );

        if(!$userWithRefreshTokenModel){
            throw new Exception("expire time ended, you have to login again");
        }

       return new RefreshTokenResponseDto(
        true,
        $userWithRefreshTokenModel->getUuid(),
        $userWithRefreshTokenModel->getFullname(),
        $userWithRefreshTokenModel->getEmail(),
        $userWithRefreshTokenModel->getUserRole(),
        $userWithRefreshTokenModel->getRefreshTokenModel()
       );
    }


    function verifyUserAccount(EmailVerificationDto $emailVerificationDto):EmailSuccessfulyActivatedResponseDto{
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

    function sendChangeForgettenPasswordEmail(ForgettenPasswordEmailDto $forgettenPasswordMailDto): ForgettenPasswordEmailResponseDto
    {
        $user = $this->userRepository->findUserByEmail($forgettenPasswordMailDto->getEmail());
        $user->createForgettenPasswordCode();
        
        $this->userRepository->updateForgettenPasswordCode($user);
        $this->emailService->sendChangeForgettenPasswordEmail($user);
        
        return new ForgettenPasswordEmailResponseDto(
            true,
            "Email successfuly sended, take your code and create new password :)"
        );
    }
}
