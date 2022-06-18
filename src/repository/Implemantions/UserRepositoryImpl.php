<?php

use Ramsey\Uuid\Nonstandard\Uuid;

require './vendor/autoload.php';
class UserRepositoryImpl implements UserRepository{
    private UserDao $userDao;
    private RefreshTokenDao $refreshTokenDao;
    private UserFactory $userFactory;
    private RefreshTokenFactory $refreshTokenFactory;
    public function __construct(
        UserDao $userDao, 
        RefreshTokenDao $refreshTokenDao,
        Factory $userFactory,
        Factory $refreshTokenFactory
    )
    {
        $this->userDao = $userDao;
        $this->refreshTokenDao = $refreshTokenDao;
        $this->userFactory = $userFactory;
        $this->refreshTokenFactory = $refreshTokenFactory;
    }

    function findAllWithPagination($startingLimit, $perPageForUsers):array
    {
        $users = $this->userDao->findAllWithPagination($startingLimit, $perPageForUsers);
        $userList = array();
        foreach($users as $u){
            $user = $this->userFactory->createInstance(
                false,
                $u->uuid,
                $u->full_name,
                $u->email,
                $u->user_password,
                $u->is_user_activated,
                $u->created_at,
                $u->updated_at
            );
            $user->setUserRole($u->user_role);
            $userList[] = $user;
        }
        return $userList;
    }
    function findOneUserByUuid($uuid):UserInterface
    {
            $userObj = $this->userDao->findUserByUuid($uuid);
            foreach($userObj as $u){
                $user = $this->userFactory->createInstance(
                    false,
                    $u->uuid,
                    $u->full_name,
                    $u->email,
                    $u->user_password,
                    $u->is_user_activated,
                    $u->created_at,
                    $u->updated_at
                );
                $user->setUserRole($u->user_role);
                return $user;
            }
    }

    function findUserByEmail($email):UserInterface{
            $userObj = $this->userDao->findUserByEmail($email);
            foreach($userObj as $u){
                $user = $this->userFactory->createInstance(
                    false,
                    $u->uuid,
                    $u->full_name,
                    $u->email,
                    $u->user_password,
                    $u->is_user_activated,
                    $u->created_at,
                    $u->updated_at
                );
                $user->setUserRole($u->user_role);
                return $user;
            }
    }

    function findUserByVerificationCode($code):UserInterface{
            $userObj = $this->userDao->findUserByActivationCode($code);
        
            foreach($userObj as $u){
                $user = $this->userFactory->createInstance(
                    false,
                    $u->uuid,
                    $u->full_name,
                    $u->email,
                    $u->user_password,
                    $u->is_user_activated,
                    $u->created_at,
                    $u->updated_at
                );
                $user->setActivationCode($u->email_activation_code);
                $user->setUserRole($u->user_role);

                return $user;
            }
    }

    function findUserByUuidWithRefreshToken($refreshToken):UserInterface{
            list($refreshTokenUuid, $userUuid ) = $this->refreshTokenDao->findRefreshTokenDetailByRefreshToken($refreshToken);
            $userObj = $this->userDao->findUserByUuid($userUuid);

            foreach($userObj as $u){

                    $user = $this->userFactory->createInstance(
                        false,
                        $u->uuid,
                        $u->full_name,
                        $u->email,
                        $u->user_password,
                        $u->is_user_activated,
                        $u->created_at,
                        $u->updated_at
                    );
                    $user->setUserRole($u->user_role);
                    
                    $refTokenModel = $this->refreshTokenFactory->createInstance(
                        false,
                        $refreshTokenUuid, 
                        $userUuid,
                        date('Y-m-d H:i:s'), 
                        date('Y-m-d H:i:s')
                    );
        
                    $refTokenModel->setRefreshToken($refreshToken);
                    $user->setRefreshTokenModel($refTokenModel);
                    return $user;
            }
    }

    function findUserByForgettenPasswordCode($passwordCode):UserInterface{
            $userObj = $this->userDao->findUserByForgettenPasswordCode($passwordCode);
        
            foreach($userObj as $u){
                $user = $this->userFactory->createInstance(
                    false,
                    $u->uuid,
                    $u->full_name,
                    $u->email,
                    $u->user_password,
                    $u->is_user_activated,
                    $u->created_at,
                    $u->updated_at
                );
                $user->setUserRole($u->user_role);
 
                return $user;
            }
        

    }

    function persistUser(User $user){
        $this->userDao->persist($user);
    }
    function persistRefreshToken(User $user){
        $this->refreshTokenDao->persist($user->getRefreshTokenModel());
    }

    function updateUserActivatedState(User $user){
        $this->userDao->updateUserActivatedState($user);
    }

    function updatePassword(User $user)
    {
        $this->userDao->updatePassword($user);
    }

    function updateForgettenPasswordCode(User $user)
    {
        $this->userDao->updateForgettenPasswordCode($user);
    }
    function updateFullName(User $user)
    {
        $this->userDao->updateFullName($user);
    }

}