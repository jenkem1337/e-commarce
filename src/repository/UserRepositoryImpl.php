<?php
require './vendor/autoload.php';
class UserRepositoryImpl implements UserRepository{
    protected UserDao $userDao;

    public function __construct(userDao $userDao)
    {
        $this->userDao = $userDao;
    }


    function findUserByEmail($email){
        try {
            $userObj = $this->userDao->findUserByEmail($email);
            foreach($userObj as $u){
                return new User(
                    $u->uuid,
                    $u->full_name,
                    $u->email,
                    $u->user_password,
                    $u->is_user_activated,
                    $u->created_at,
                    $u->updated_at
                );
    
            }
        } catch (Exception $th) {
            false;
        }

    }

    function findUserByVerificationCode($code){
        try{
            $userObj = $this->userDao->findUserByActivationCode($code);
        
            foreach($userObj as $u){
                $user = new User(
                    $u->uuid,
                    $u->full_name,
                    $u->email,
                    $u->user_password,
                    $u->is_user_activated,
                    $u->created_at,
                    $u->updated_at
                );
                $user->setActivationCode($u->email_activation_code);
                return $user;
            }
        }catch(Exception $e){
            false;
        }

    }
    function save(User $user){
        $this->userDao->save($user);
    }

    function updateUserActivatedState(User $user){
        $this->userDao->updateUserActivatedState($user);
    }

}