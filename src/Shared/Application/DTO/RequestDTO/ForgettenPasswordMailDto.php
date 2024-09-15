<?php 
class ForgettenPasswordEmailDto {
    protected $email;

    public function __construct($email)
    {
        $this->email = $email;
    }



    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }
}