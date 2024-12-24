<?php

class OrderCreatedEmailDto {
    function __construct(
        private $fullname,
        private $email,
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
}