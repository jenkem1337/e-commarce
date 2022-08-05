<?php 
require "./vendor/autoload.php";

class IsAdminMiddleware extends Middleware {
    function check(): bool
    {
        try {
            $jwtPayloadDto = JwtPayloadDto::getInstance();
            $payload = $jwtPayloadDto->getPayload();
            if($payload->user_role !== "ADMIN"){
                throw new UserRoleException('admin');
            }
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