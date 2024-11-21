<?php

class PlaceOrderDto {
    function __construct(
        
        private $userUuid,
        private $email,
        private $paymentMethod,
        private $paymentDetail,
        private $amount,
        private $addressTitle,
        private $addressOwnerName,
        private $addressOwnerSurname,
        private $fullAddress,
        private $addressCountry,
        private $addressProvince,
        private $addressDistrict,
        private $addressZipCode,
        private $orderItems
       ){}

    public function getOrderItems() {
        return $this->orderItems;
    }
    public function getUserUuid() {
        return $this->userUuid;
    }

    public function getPaymentMethod() {
        return $this->paymentMethod;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getAddressTitle() {
        return $this->addressTitle;
    }

    public function getAddressOwnerName() {
        return $this->addressOwnerName;
    }

    public function getAddressOwnerSurname() {
        return $this->addressOwnerSurname;
    }

    public function getFullAddress() {
        return $this->fullAddress;
    }

    public function getAddressCountry() {
        return $this->addressCountry;
    }

    public function getAddressProvince() {
        return $this->addressProvince;
    }

    public function getAddressDistrict() {
        return $this->addressDistrict;
    }

    public function getAddressZipCode() {
        return $this->addressZipCode;
    }

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Get the value of paymentDetail
         */ 
        public function getPaymentDetail()
        {
                return $this->paymentDetail;
        }
}