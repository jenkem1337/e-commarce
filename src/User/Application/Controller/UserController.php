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
        
        http_response_code(200);
        echo json_encode($response);    

    }
    function changeForgettenPassword(){
        $jsonBody = json_decode(file_get_contents('php://input'));

        $response = $this->userService->changeForgettenPassword(new ForgettenPasswordDto($jsonBody->verification_code, $jsonBody->new_password));       

        http_response_code(200);
        echo json_encode($response);    

    }
    function sendChangeForgettenPasswordEmail(){
        $jsonBody = json_decode(file_get_contents('php://input'));

        $response = $this->authService->sendChangeForgettenPasswordEmail(new ForgettenPasswordEmailDto($jsonBody->email));
        http_response_code(200);
        echo json_encode($response);    


        
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

        http_response_code(200);
        echo json_encode($responseList);    

    }
    function findOneUserByUuid($uuid){
        $response = $this->userService->findOneUserByUuid(new FindOneUserByUuidDto($uuid));
        http_response_code(200);
        echo json_encode($response);    

        
    }
    
    function changeFullName(){
        $jsonBody = json_decode(file_get_contents('php://input'));

        $jwtPayload = JwtPayloadDto::getInstance();
        $payload = $jwtPayload->getPayload();
        $response = $this->userService->changeFullName(new ChangeFullNameDto($payload->email, $jsonBody->new_full_name));
        $jwtPayload->removePayload();

        http_response_code(200);
        echo json_encode($response);    
    }       
}