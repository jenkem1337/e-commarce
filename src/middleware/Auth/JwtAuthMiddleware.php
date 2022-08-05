<?php
require "./vendor/autoload.php";
use Ramsey\Uuid\Nonstandard\Uuid;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$dotenv = Dotenv\Dotenv::createImmutable("C:\\xampp\htdocs\\");
$dotenv->load();

class JwtAuthMiddleware extends Middleware {
    function check():bool{
        try {
            $headers = apache_request_headers();
        
            if(!$headers['Authorization']) throw new NullException("authorization header");
            
            $authorization = explode(' ', $headers['Authorization']);
            $jwt = $authorization[1];
            
            if(!$jwt) throw new DoesNotExistException('jwt token');
            
            $data = JWT::decode($jwt, new Key($_ENV['SECRET_KEY'], "HS256"));
            $jwtPayloadDto = JwtPayloadDto::getInstance();
            $jwtPayloadDto->setPayload($data);
            return parent::check();
    
        } catch (Exception $e) {
            return (new ErrorResponseDto($e->getMessage(), $e->getCode()))
                                        ->onError(function(ErrorResponseDto $err){
                                            json_encode([
                                                'error-message' => $err->getErrorMessage(),
                                                'status-code' => $err->getErrorCode()
                                            ]);
                                        });


        }
    }
}