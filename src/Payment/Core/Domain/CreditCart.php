<?php

class CreditCart implements PaymentStrategy{
    private function __construct(
        private $number,
        private $expirationDate,
        private $cvc,
        private $owner
    ) {
        $this->checkCart();
    }

    static function new($number, $expirationDate, $cvc, $owner) {
        return new CreditCart($number, $expirationDate, $cvc, $owner);
    }
    function checkCart(){
        $this->luhnCheckForCreditCartNumber($this->number) ?: throw new InvalidCartNumberException();
        $this->isValidCardExpirationDate($this->expirationDate) ?: throw new InvalidCartExpirationExcepion(); 
        $this->isValidCVC($this->cvc) ?: throw new InvalidCartCVCException();
        $this->isValidCartOwner($this->owner) ?: throw new InvalidCartOwnerException();
    }
    private function luhnCheckForCreditCartNumber($cardNumber) {
       
        $cardNumber = str_replace('-', '', $cardNumber);
        
        $digits = strrev($cardNumber);
        $total = 0;
    
        for ($i = 0; $i < strlen($digits); $i++) {
            $digit = (int) $digits[$i];
    
            if ($i % 2 == 1) {
                $digit *= 2;
    
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
    
            $total += $digit;
        }
    
        return $total % 10 == 0;
    }
    
    private function isValidCardExpirationDate($expirationDate) {
        
        list($expMonth, $expYear) = explode('/', $expirationDate);
    
        $expYear += 2000;
    
        $currentYear = date('Y');
        $currentMonth = date('m');
    
        if ($expMonth < 1 || $expMonth > 12) {
            return false;
        }
        if ($expYear > $currentYear || ($expYear == $currentYear && $expMonth >= $currentMonth)) {
            return true;  
        } 
        return false;
        
    }
    private function isValidCVC($cvc) {
        if(!ctype_digit($cvc)){
            return false;
        }
        if (strlen($cvc) == 0 || strlen($cvc) > 3 || strlen($cvc) != 3) {
            return false;
        }
        return true;
    }
    private function isValidCartOwner($cartOwner) {
        if(!$cartOwner || trim($cartOwner) == ""){
            return false;
        }
        return true;
    }

    function number() {return $this->number;}
    function expirationDate() {return $this->expirationDate;}
    function cvc() {return $this->cvc;}
    function owner() {return $this->owner;}
}