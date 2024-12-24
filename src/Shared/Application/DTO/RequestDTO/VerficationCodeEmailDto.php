<?php

class VerficationCodeEmailDto {

    function __construct(
        private $fullname,
        private $email,
        private $activationCode
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
         * Get the value of activationCode
         */ 
        public function getActivationCode()
        {
                return $this->activationCode;
        }
}