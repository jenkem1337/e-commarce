<?php

use Ramsey\Uuid\Nonstandard\Uuid;
use Firebase\JWT\JWT;

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
        $issuedAt = time();
        $expireTime = $issuedAt + (60 * 60 * 24);
         $payload = [
             "exp"=> $expireTime ,
             "iat"=>$issuedAt,
             "user_uuid"=>$response->getData()["data"]["uuid"],
             "full_name"=>$response->getData()["data"]["full_name"],
             "email"=>$response->getData()["data"]["email"],
             "user_role"=>$response->getData()["data"]["role"]
         ];
         
         $token = JWT::encode($payload,  $_ENV["SECRET_KEY"], "HS256");
         http_response_code(200);
         $refreshToken = $response->getData()["data"]["refresh_token"];
         echo json_encode([
             "message"=>"Login Process Succesful",
             "access_token"=> $token,
             "refresh_token"=>$refreshToken
         ]);

        
    }
    

    function register(){
        $jsonBody = json_decode(file_get_contents('php://input'));
        
        $userCreationalDto = new UserCreationalDto(
            Uuid::uuid4(), 
            $jsonBody->full_name,
            $jsonBody->email,
            $jsonBody->password,
            0,
            date ('Y-m-d H:i:s'),
            date ('Y-m-d H:i:s')
        );

        $response = $this->authService->register($userCreationalDto);
        http_response_code(200);
        echo json_encode($response);    


    }

    function refreshToken(){
            
            $jsonBody = json_decode(file_get_contents('php://input'));
        
            $response = $this->authService->refreshToken(new RefreshTokenDto($jsonBody->refresh_token));
            $issuedAt = time();
            $expireTime = $issuedAt + (60 * 60 * 24);
             $payload = [
                 "exp"=> $expireTime ,
                 "iat"=>$issuedAt,
                 "user_uuid"=>$response->getData()["data"]["uuid"],
                 "full_name"=>$response->getData()["data"]["full_name"],
                 "email"=>$response->getData()["data"]["email"],
                 "user_role"=>$response->getData()["data"]["role"]
             ];
             
             $token = JWT::encode($payload,  $_ENV["SECRET_KEY"], "HS256");
             http_response_code(200);
             $refreshToken = $response->getData()["data"]["refresh_token"];
             echo json_encode([
                 "message"=>"Token Refreshed",
                 "access_token"=> $token,
                 "refresh_token"=>$refreshToken
             ]);
        }
    function verifyUserAccount(){
        $code = isset($_GET['code']) ? $_GET['code'] :"";
        $response = $this->authService->verifyUserAccount(new EmailVerificationDto($code));
        http_response_code(200);
        echo json_encode($response);    

    }
}