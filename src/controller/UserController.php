<?php
class UserController {
    private AuthService $authService;
    private UserService $userService;
    function __construct(UserService $userService,AuthService $authService)
    {
        $this->userService = $userService;
        $this->authService = $authService;
    }

    function changePassword(){
        $jsonBody = json_decode(file_get_contents('php://input'));
        
        $jwtPayload = JwtPayloadDto::getInstance();
        $payload = $jwtPayload->getPayload();
        $response = $this->userService->changePassword(new ChangePasswordDto($payload->email, $jsonBody->old_password, $jsonBody->new_password));
        
        $jwtPayload->removePayload();
        
        $response->onSucsess(function(PasswordChangeResponseDto $res) {
            http_response_code(200); 
            echo json_encode($res);

        })->onError(function(ErrorResponseDto $err){
            echo json_encode($err);    
            http_response_code($err->getErrorCode());                                        
        });
    }
    function changeForgettenPassword(){
        $jsonBody = json_decode(file_get_contents('php://input'));

        $response = $this->userService->changeForgettenPassword(new ForgettenPasswordDto($jsonBody->verification_code, $jsonBody->new_password));       

        $response->onSucsess(function(ForgettenPasswordResponseDto $res){
            echo json_encode($res);
            http_response_code(200);
        })->onError(function(ErrorResponseDto $err){
            echo json_encode($err);    
            http_response_code($err->getErrorCode());                                        
        });
    }
    function sendChangeForgettenPasswordEmail(){
        $jsonBody = json_decode(file_get_contents('php://input'));

        $response = $this->authService->sendChangeForgettenPasswordEmail(new ForgettenPasswordEmailDto($jsonBody->email));
        $response->onSucsess(function(ForgettenPasswordEmailResponseDto $res){
            echo json_encode($res);
            http_response_code(200);
        })->onError(function(ErrorResponseDto $err){
            echo json_encode($err);    
            http_response_code($err->getErrorCode());                                        

        });

        
    }
    function listAllUser(){
        $pageNum = isset($_GET['page']) ? $_GET['page'] : 1;
        $perPageForUsers = 10;
        $responseList = $this->userService->listAllUser(
            new ListAllUserDto(
                $perPageForUsers,
                $pageNum
            )
        );

        $responseList->onSucsess(function(AllUserResponseDto $response){
            echo json_encode($response);
        });
    }
    function findOneUserByUuid($uuid){
        $response = $this->userService->findOneUserByUuid(new FindOneUserByUuidDto($uuid));
        $response->onSucsess(function(OneUserFoundedResponseDto $res){
            echo json_encode($res);
            http_response_code(200);
        })->onError(function(ErrorResponseDto $err){
            echo json_encode($err);    
            http_response_code($err->getErrorCode());                                        

        });
        
    }
    
    function changeFullName(){
        $jsonBody = json_decode(file_get_contents('php://input'));

        $jwtPayload = JwtPayloadDto::getInstance();
        $payload = $jwtPayload->getPayload();
        $response = $this->userService->changeFullName(new ChangeFullNameDto($payload->email, $jsonBody->new_full_name));
        $jwtPayload->removePayload();

        $response->onSucsess(function(FullNameChangedResponseDto $res){
            http_response_code(200);
            echo json_encode($res);

        })->onError(function(ErrorResponseDto $err){
            echo json_encode($err);    
            http_response_code($err->getErrorCode());                                        
        });
    }       
}