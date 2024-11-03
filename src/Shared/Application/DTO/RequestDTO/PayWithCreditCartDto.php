<?php
class PayWithCreditCartDto {
    function __construct(
        private $userUuid,
        private $paymentMethod,
        private $amount,
        private $cartNumber = null,
        private $cartExpirationDate = null,
        private $cartCVC = null,
        private $cartOwner = null
    ){}
    

        /**
         * Get the value of userUuid
         */ 
        public function getUserUuid()
        {
                return $this->userUuid;
        }

        /**
         * Get the value of paymentMethod
         */ 
        public function getPaymentMethod()
        {
                return $this->paymentMethod;
        }

        /**
         * Get the value of amount
         */ 
        public function getAmount()
        {
                return $this->amount;
        }

        /**
         * Get the value of cartNumber
         */ 
        public function getCartNumber()
        {
                return $this->cartNumber;
        }

        /**
         * Get the value of cartExpirationDate
         */ 
        public function getCartExpirationDate()
        {
                return $this->cartExpirationDate;
        }

        /**
         * Get the value of cartCVC
         */ 
        public function getCartCVC()
        {
                return $this->cartCVC;
        }

        /**
         * Get the value of cartOwner
         */ 
        public function getCartOwner()
        {
                return $this->cartOwner;
        }
}