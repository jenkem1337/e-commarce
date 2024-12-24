<?php

class ForgottenPasswordEmailDto {
    function __construct(
        private $fullname,
        private $email,
        private $forgettenPasswordCode
    ){}


        /**
         * Get the value of fullname
         */ 
        public function getFullname()
        {
                return $this->fullname;
        }

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Get the value of foregettenPasswordCode
         */ 
        public function getForgettenPasswordCode()
        {
                return $this->forgettenPasswordCode;
        }
}