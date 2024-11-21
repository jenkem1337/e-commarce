<?php

class CreationalShippingDto {
    function __construct(
        private $orderAmount,
        private $addressTitle,
        private $addressOwnerName,
        private $addressOwnerSurname,
        private $fullAddress,
        private $addressCountry,
        private $addressProvince,
        private $addressDistrict,
        private $addressZipCode

    ){}

        /**
         * Get the value of orderAmount
         */ 
        public function getOrderAmount()
        {
                return $this->orderAmount;
        }

        /**
         * Get the value of addressTitle
         */ 
        public function getAddressTitle()
        {
                return $this->addressTitle;
        }

        /**
         * Get the value of addressOwnerName
         */ 
        public function getAddressOwnerName()
        {
                return $this->addressOwnerName;
        }

        /**
         * Get the value of addressOwnerSurname
         */ 
        public function getAddressOwnerSurname()
        {
                return $this->addressOwnerSurname;
        }

        /**
         * Get the value of fullAddress
         */ 
        public function getFullAddress()
        {
                return $this->fullAddress;
        }

        /**
         * Get the value of addressCountry
         */ 
        public function getAddressCountry()
        {
                return $this->addressCountry;
        }

        /**
         * Get the value of addressProvince
         */ 
        public function getAddressProvince()
        {
                return $this->addressProvince;
        }

        /**
         * Get the value of addressDistrict
         */ 
        public function getAddressDistrict()
        {
                return $this->addressDistrict;
        }

        /**
         * Get the value of addressZipCode
         */ 
        public function getAddressZipCode()
        {
                return $this->addressZipCode;
        }
}