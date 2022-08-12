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
        $res = $this->authService->login($userLoginDto);
        $res->onSucsess(function($response){
            
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
                 http_response_code(200);
                 echo json_encode([
                     "message"=>"Login Process Succesful",
                     "access_token"=> $token,
                     "refresh_token"=>$refreshTokenModel->getRefreshToken()
                 ]);
     
        })->onError(function($err){
            echo json_encode([
                'error_message' => $err->getErrorMessage(),
                'status_code' => $err->getErrorCode()
            ]);
            http_response_code($err->getErrorCode());
        });
        
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

        $res = $this->authService->register($userCreationalDto);
        $res->onSucsess(function($response){
            
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
            
    
        })->onError(function($err){
            echo json_encode([
                'error_message' => $err->getErrorMessage(),
                'status_code' => $err->getErrorCode()
            ]);
            http_response_code($err->getErrorCode());

        });

    }

    function refreshToken(){
            
            $jsonBody = json_decode(file_get_contents('php://input'));
        
            $res = $this->authService->refreshToken(new RefreshTokenDto($jsonBody->refresh_token));
            $res->onSucsess(function($response){
                
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
                
    
            })->onError(function($err){
                echo json_encode([
                    'error_message' => $err->getErrorMessage(),
                    'status_code' => $err->getErrorCode()
                ]);    
                http_response_code($err->getErrorCode());

            });
    }
    function verifyUserAccount(){
        $code = isset($_GET['code']) ? $_GET['code'] :"";
        $res = $this->authService->verifyUserAccount(new EmailVerificationDto($code));
        
        $res->onSucsess(function($response){
                http_response_code(200);
                echo json_encode([
                    'uuid'=>$response->getUuid(),
                    'full_name'=>$response->getFullname(),
                    'email'=>$response->getEmail(),
                    'is_user_activated'=>$response->getIsUserActivaed(),
                    'created_at'=>$response->getCreated_at(),
                    'updated_at'=>$response->getUpdated_at()
            ]);    
        })->onError(function($err){
            echo json_encode([
                'error_message' => $err->getErrorMessage(),
                'status_code' => $err->getErrorCode()
            ]);    
            http_response_code($err->getErrorCode());

        });
    }
}