<?php

class PayOrderDto {
    function __construct(
        private $userUuid,
        private $paymentMethod,
        private $paymentDetail,
        private $orderAmount
    ){}

        /**
         * Get the value of paymentMethod
         */ 
        public function getPaymentMethod()
        {
                return $this->paymentMethod;
        }

        /**
         * Get the value of paymentDetail
         */ 
        public function getPaymentDetail()
        {
                return $this->paymentDetail;
        }

        /**
         * Get the value of orderAmount
         */ 
        public function getOrderAmount()
        {
                return $this->orderAmount;
        }

        /**
         * Get the value of userUuid
         */ 
        public function getUserUuid()
        {
                return $this->userUuid;
        }
}