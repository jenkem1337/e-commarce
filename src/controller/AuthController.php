<?php


require './vendor/autoload.php';
use Ramsey\Uuid\Nonstandard\Uuid;

class AuthController {
    private AuthService $authService;

    function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    function login(){
        $jsonBody = json_decode(file_get_contents('php://input'));
        $userLoginDto = new UserLoginDto($jsonBody->email, $jsonBody->password); 
        $response = $this->authService->login($userLoginDto);
    }

    function register(){
        $jsonBody = json_decode(file_get_contents('php://input'));
        
        $userCreationalDto = new UserCreationalDto(
            Uuid::uuid4(), 
            $jsonBody->full_name,
            $jsonBody->email,
            $jsonBody->password,
            false,
            date ('Y-m-d H:i:s'),
            date ('Y-m-d H:i:s')
        );

        $response = $this->authService->register($userCreationalDto);
        if($response->isSuccess()){
            echo json_encode([
                'uuid'=>$response->getUuid(),
                'full_name'=>$response->getFullname(),
                'email'=>$response->getEmail(),
                'is_user_activated'=>$response->getIsUserActivaed(),
                'activation_message'=> "Verification mail has been sended",
                'created_at'=>$response->getCreated_at(),
                'updated_at'=>$response->getUpdated_at()
            ]);
            die();
        }

    }
    function verifyUserAccount(){
        $code = isset($_GET['code']) ? $_GET['code'] :"";
        $response = $this->authService->verifyUserAccount(new EmailVerificationDto($code));
        if($response->isSuccess()){
            echo json_encode([
                'uuid'=>$response->getUuid(),
                'full_name'=>$response->getFullname(),
                'email'=>$response->getEmail(),
                'is_user_activated'=>$response->getIsUserActivaed(),
                'created_at'=>$response->getCreated_at(),
                'updated_at'=>$response->getUpdated_at()
            ]);
            die();

        }
    }
}