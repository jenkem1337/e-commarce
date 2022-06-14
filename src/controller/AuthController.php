<?php


require './vendor/autoload.php';
use Ramsey\Uuid\Nonstandard\Uuid;
use Firebase\JWT\JWT;

$dotenv = Dotenv\Dotenv::createImmutable("C:\\xampp\htdocs\\");
$dotenv->load();


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
        if($response->isSuccess()){
           $refreshTokenModel = $response->getRefreshToken();
           $issuedAt = time();
           $expireTime = $issuedAt + (60 * 60 * 24);
            $payload = [
                "exp"=> $expireTime ,
                "iat"=>$issuedAt,
                "user_uuid"=>$response->getUuid(),
                "full_name"=>$response->getFullName(),
                "email"=>$response->getEmail(),
                "user_role"=>$response->getUserRole()
            ];
            
            $token = JWT::encode($payload,  $_ENV["SECRET_KEY"], "HS256");
            http_response_code(202);
            echo json_encode([
                "message"=>"Login Process Succesful",
                "access_token"=> $token,
                "refresh_token"=>$refreshTokenModel->getRefreshToken()
            ]);
            die();
        }
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
            http_response_code(201);
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

    function refreshToken(){
            
            $jsonBody = json_decode(file_get_contents('php://input'));
        
            $response = $this->authService->refreshToken(new RefreshTokenDto($jsonBody->refresh_token));
            if($response->isSuccess()){
                $refreshTokenModel = $response->getRefreshToken();
                $issuedAt = time();
                $expireTime = $issuedAt + (60 * 60 * 24);
                 $payload = [
                     "exp"=> $expireTime ,
                     "iat"=>$issuedAt,
                     "user_uuid"=>$response->getUuid(),
                     "full_name"=>$response->getFullName(),
                     "email"=>$response->getEmail(),
                     "user_role"=>$response->getUserRole()
                 ];
                 
                 $token = JWT::encode($payload,  $_ENV["SECRET_KEY"], "HS256");
                 http_response_code(201);
                 echo json_encode([
                     "message"=>"Token Refreshed",
                     "access_token"=> $token,
                     "refresh_token"=>$refreshTokenModel->getRefreshToken()
                 ]);
                 die();
             }
    
 
    }
    function verifyUserAccount(){
        $code = isset($_GET['code']) ? $_GET['code'] :"";
        $response = $this->authService->verifyUserAccount(new EmailVerificationDto($code));
        if($response->isSuccess()){
            http_response_code(200);
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