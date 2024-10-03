<?php

use Ramsey\Uuid\Nonstandard\Uuid;

require './vendor/autoload.php';
class UserRepositoryImpl extends TransactionalRepository implements UserRepository{
    private UserDao $userDao;
    private RefreshTokenDao $refreshTokenDao;
    public function __construct(
        UserDao $userDao, 
        RefreshTokenDao $refreshTokenDao,
    )
    {
        $this->userDao = $userDao;
        $this->refreshTokenDao = $refreshTokenDao;
        parent::__construct($this->userDao);
    }

    function findAllWithPagination($startingLimit, $perPageForUsers, UserCollection $userCollection):IteratorAggregate
    {
        $users = $this->userDao->findAllWithPagination($startingLimit, $perPageForUsers);
        foreach($users as $u){
            $user = User::newInstance(
                $u->uuid,
                $u->full_name,
                $u->email,
                $u->user_password,
                $u->is_user_activated,
                $u->created_at,
                $u->updated_at
            );
            $user->setUserRole($u->user_role);
            $userCollection->add($user);
        }
        return $userCollection;
    }
    function findOneUserByUuid($uuid):UserInterface
    {
            $userObj = $this->userDao->findUserByUuid($uuid);
                $user = User::newInstance(
                    $userObj->uuid,
                    $userObj->full_name,
                    $userObj->email,
                    $userObj->user_password,
                    $userObj->is_user_activated,
                    $userObj->created_at,
                    $userObj->updated_at
                );
                $user->setUserRole($userObj->user_role);
                return $user;
            
    }

    function findUserByEmail($email):UserInterface{
            $userObj = $this->userDao->findUserByEmail($email);
                $user = User::newInstance(
                    $userObj->uuid,
                    $userObj->full_name,
                    $userObj->email,
                    $userObj->user_password,
                    $userObj->is_user_activated,
                    $userObj->created_at,
                    $userObj->updated_at
                );
                $user->setUserRole($userObj->user_role);
                return $user;
            
    }

    function findUserByVerificationCode($code):UserInterface{
            $userObj = $this->userDao->findUserByActivationCode($code);
        
                $user = User::newInstance(
                    $userObj->uuid,
                    $userObj->full_name,
                    $userObj->email,
                    $userObj->user_password,
                    $userObj->is_user_activated,
                    $userObj->created_at,
                    $userObj->updated_at
                );
                $user->setActivationCode($userObj->email_activation_code);
                $user->setUserRole($userObj->user_role);

                return $user;
            
    }

    function findUserByUuidWithRefreshToken($refreshToken):UserInterface{
            list($refreshTokenUuid, $userUuid ) = $this->refreshTokenDao->findRefreshTokenDetailByRefreshToken($refreshToken);
            $userObj = $this->userDao->findUserByUuid($userUuid);

            $user = User::newInstance(
                $userObj->uuid,
                $userObj->full_name,
                $userObj->email,
                $userObj->user_password,
                $userObj->is_user_activated,
                $userObj->created_at,
                $userObj->updated_at
            );
            $user->setUserRole($userObj->user_role);
            
            $refTokenModel = RefreshToken::newInstance(
                $refreshTokenUuid, 
                $userUuid,
                date('Y-m-d H:i:s'), 
                date('Y-m-d H:i:s')
            );

            $refTokenModel->setRefreshToken($refreshToken);
            
            $user->setRefreshToken($refTokenModel);
            return $user;
            
    }

    function findUserByForgettenPasswordCode($passwordCode):UserInterface{
            $userObj = $this->userDao->findUserByForgettenPasswordCode($passwordCode);
        
                $user = User::newInstance(
                    $userObj->uuid,
                    $userObj->full_name,
                    $userObj->email,
                    $userObj->user_password,
                    $userObj->is_user_activated,
                    $userObj->created_at,
                    $userObj->updated_at
                );
                $user->setUserRole($userObj->user_role);
 
                return $user;
            
        

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