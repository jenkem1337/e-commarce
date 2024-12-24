<?php
use Ramsey\Uuid\Nonstandard\Uuid;

class AuthServiceImpl implements AuthService{
    private UserRepository $userRepository;
    private MessageBroker $messageBroker;

    function __construct(
        UserRepository $userRepo, 
        MessageBroker $messageBroker, 
        )
    {
        $this->userRepository = $userRepo;
        $this->messageBroker   = $messageBroker;
    }
    function login(UserLoginDto $userLoginDto):ResponseViewModel{
        $user = $this->userRepository->findUserByEmail($userLoginDto->getEmail());
        
        if($user->isNull()){
            throw new NotFoundException('user');
        }

        $user->createRefreshTokenModel();

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

        $user = User::createNewUser(
            $userCreationalDto->getUuid(),
            $userCreationalDto->getFullname(),
            $userCreationalDto->getEmail(),
            $userCreationalDto->getPassword(),
            $userCreationalDto->getCreated_at(),
            $userCreationalDto->getUpdated_at()
        );
        
        $this->userRepository->persistUser($user);
        
        $this->messageBroker->emit("send-register-activation-email", [
            "fullname"=> $user->getFullname(),
            "email"=>$user->getEmail(),
            "activationCode"=> $user->getActivationCode()
        ]);

        return new SuccessResponse([
            "message" => "User registered successfully !",
            "data" => [
                "uuid" => $user->getUuid(),
                "full_name" => $user->getFullname(),
                "email" => $user->getEmail(),
                "role" => $user->getUserRole(),
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
        
        $this->messageBroker->emit("send-forgetten-password-email", [
            "fullname"=> $user->getFullname(),
            "email"=>$user->getEmail(),
            "forgettenPasswordCode"=> $user->getForegettenPasswordCode()
        ]);
        
        return new SuccessResponse( [
            "message" => "Email successfuly sended, take your code and create new password :)",
            "data" => [
                "email" => $forgettenPasswordMailDto->getEmail()
            ]
        ]);
    }
}
