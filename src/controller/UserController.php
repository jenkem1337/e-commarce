<?php
require "./vendor/autoload.php";
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
        
        if($response->isSuccess()){
            http_response_code(200); 
            echo json_encode(["message"=>$response->getSuccesMessage()]);
            die();
        }
    }
    function changeForgettenPassword(){
        $jsonBody = json_decode(file_get_contents('php://input'));

        $response = $this->userService->changeForgettenPassword(new ForgettenPasswordDto($jsonBody->verification_code, $jsonBody->new_password));       

        
        if($response->isSuccess()){
            echo json_encode(["message"=>$response->getSuccesMessage()]);
            die();
        }
    }
    function sendChangeForgettenPasswordEmail(){
        $jsonBody = json_decode(file_get_contents('php://input'));

        $response = $this->authService->sendChangeForgettenPasswordEmail(new ForgettenPasswordEmailDto($jsonBody->email));
        
        if($response->isSuccess()){
            echo json_encode(["message"=>$response->getSuccesMessage()]);
            die();
        }
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
        foreach($responseList as $response){
             echo json_encode([
                 "uuid"=>$response->getUuid(),
                 "full_name"=>$response->getFullname(),
                 "email"=>$response->getEmail(),
                 "password"=>$response->getPassword(),
                 "user_role"=>$response->getUserRole(),
                 "is_user_activated"=>$response->getIsUserActivated(),
                 "created_at"=>$response->getCreatedAt(),
                 "updated_at"=>$response->getUpdatedAt()
             ]);
        }
        die();

    }
    function findOneUserByUuid($uuid){
        $response = $this->userService->findOneUserByUuid(new FindOneUserByUuidDto($uuid));
        if($response->isSuccess()){
            echo json_encode([
                "uuid"=>$response->getUuid(),
                "full_name"=>$response->getFullname(),
                "email"=>$response->getEmail(),
                "password"=>$response->getPassword(),
                "user_role"=>$response->getUserRole(),
                "is_user_activated"=>$response->getIsUserActivated(),
                "created_at"=>$response->getCreatedAt(),
                "updated_at"=>$response->getUpdatedAt()
            ]);
            die();
        }
    }
    function changeFullName(){
        $jsonBody = json_decode(file_get_contents('php://input'));

        $jwtPayload = JwtPayloadDto::getInstance();
        $payload = $jwtPayload->getPayload();
        $response = $this->userService->changeFullName(new ChangeFullNameDto($payload->email, $jsonBody->new_full_name));
        $jwtPayload->removePayload();

        if($response->isSuccess()){
            http_response_code(200);
            echo json_encode(["message"=>$response->getSuccesMessage()]);
            die();
        }
    }       
}