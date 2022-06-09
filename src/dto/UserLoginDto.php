<?php

class UserLoginDto{
    protected $email;

    protected $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }



    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }
}