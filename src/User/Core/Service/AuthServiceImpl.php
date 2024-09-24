<?php
use Ramsey\Uuid\Nonstandard\Uuid;

class AuthServiceImpl implements AuthService{
    private UserRepository $userRepository;
    private EmailService $emailService;
    private UserFactory $userFactory;
    private RefreshTokenFactory $refreshTokenFactory;

    function __construct(
        UserRepository $userRepo, 
        EmailService $emailService, 
        Factory $userFactory, 
        Factory $refreshTokenFactory
        )
    {
        $this->userRepository = $userRepo;
        $this->emailService   = $emailService;
        $this->userFactory = $userFactory;
        $this->refreshTokenFactory = $refreshTokenFactory;
    }
    function login(UserLoginDto $userLoginDto):ResponseViewModel{
        $user = $this->userRepository->findUserByEmail($userLoginDto->getEmail());
        if($user->isNull()){
            throw new NotFoundException('user');
        }

        $refreshToken = $this->refreshTokenFactory->createInstance(
            true,
            Uuid::uuid4(),
            $user->getUuid(),
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s'));
        $refreshToken->createRefreshToken(60*60*24*10);

        $user->setRefreshTokenModel($refreshToken);

        $this->userRepository->persistRefreshToken($user);

        $user->comparePassword($userLoginDto->getPassword());
        $user->isUserActiveted();

        return new SuccessResponse([
                "message" => "User loged in successfully !",
                "data" => [
                    "uuid" => $user->getUuid(),
                    "full_name" => $user->getFullname(),
                    "email" => $user->getEmail(),
                    "role" => $user->getUserRole(),
                    "refresh_token" => $user->getRefreshTokenModel()->getRefreshToken()
                ]
            ]);

            

    }
    
    function register(UserCreationalDto $userCreationalDto):ResponseViewModel{

        $isUserExist = $this->userRepository->findUserByEmail($userCreationalDto->getEmail());
        
        if(!$isUserExist->isNull()){
            throw new AlreadyExistException('user');
        }

        $user = $this->userFactory->createInstance(
            true,
            $userCreationalDto->getUuid(),
            $userCreationalDto->getFullname(),
            $userCreationalDto->getEmail(),
            $userCreationalDto->getPassword(),
            $userCreationalDto->getIsUserActivaed(),
            $userCreationalDto->getCreated_at(),
            $userCreationalDto->getUpdated_at()
        );
        

        $user->hashPassword($user->getPassword());
        $user->createActivationCode();

        $this->userRepository->persistUser($user);
        $this->emailService->sendVerificationCode($user);

        return new SuccessResponse([
            "message" => "User registered successfully !",
            "data" => [
                "uuid" => $user->getUuid(),
                "full_name" => $user->getFullname(),
                "email" => $user->getEmail(),
                "role" => $user->getUserRole(),
                "refresh_token" => $user->getRefreshTokenModel()->getRefreshToken()
            ]
        ]);

    }


    function refreshToken(RefreshTokenDto $refreshTokenDto):ResponseViewModel{
        $userWithRefreshTokenModel = $this->userRepository->findUserByUuidWithRefreshToken(
            $refreshTokenDto->getRefreshToken()
        );

        if($userWithRefreshTokenModel->isNull()){
            throw new RefreshTokenExpireTimeEndedException();
        }

        return new SuccessResponse([
            "message" => "Token refreshed successfully !",
            "data" => [
                "uuid" => $userWithRefreshTokenModel->getUuid(),
                "full_name" => $userWithRefreshTokenModel->getFullname(),
                "email" => $userWithRefreshTokenModel->getEmail(),
                "role" => $userWithRefreshTokenModel->getUserRole(),
                "refresh_token" => $userWithRefreshTokenModel->getRefreshTokenModel()->getRefreshToken()
            ]
        ]);
}


    function verifyUserAccount(EmailVerificationDto $emailVerificationDto):ResponseViewModel{
        $user = $this->userRepository->findUserByVerificationCode($emailVerificationDto->getCode());
        if($user->isNull()){
            throw new NotFoundException('user');
        }

        $this->userRepository->updateUserActivatedState($user);

        $updatedUser = $this->userRepository->findUserByEmail($user->getEmail());
        return new SuccessResponse([
            "message" => "Email verifyed successfully",
            "data" => [
                "uuid" => $updatedUser->getUuid(),
                "full_name" => $updatedUser->getFullname(),
                "email" => $updatedUser->getEmail(),
                "is_user_activated" => $updatedUser->getIsUserActiveted(),
                "craeted_at" => $updatedUser->getCreatedAt(),
                "updated_at" => $updatedUser->getUpdatedAt()
    
            ]
        ]);
    }

    function sendChangeForgettenPasswordEmail(ForgettenPasswordEmailDto $forgettenPasswordMailDto): ResponseViewModel
    {
        $user = $this->userRepository->findUserByEmail($forgettenPasswordMailDto->getEmail());
        if($user->isNull()){
            throw new DoesNotExistException('email');
        }
        $user->createForgettenPasswordCode();
        
        $this->userRepository->updateForgettenPasswordCode($user);
        $this->emailService->sendChangeForgettenPasswordEmail($user);
        
        return new SuccessResponse([
            "message" => "Email successfuly sended, take your code and create new password :)",
            "data" => [
                "email" => $forgettenPasswordMailDto->getEmail()
            ]
        ]);
    }
}
