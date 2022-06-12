<?php
class ChangeFullNameDto {
    protected $email;

    protected $newFullname;

    public function __construct($email, $newFullname)
    {
        $this->email = $email;
        $this->newFullname = $newFullname;
    }



    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of fullname
     */ 
    public function getNewFullname()
    {
        return $this->newFullname;
    }
}