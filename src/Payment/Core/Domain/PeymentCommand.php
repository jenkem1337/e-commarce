<?php

class PeymentCommand {
    private function __construct(
            private $peymentMethod,
            private $cardNumber,
            private $cardExpirationDate,
            private $CVC,
            private $cardOwnerFullName,
            private $amount
        ){}
    

    
    static function createForCreditCart($cardNumber, $cardExpirationDate, $CVC, $cardOwnerFullName, $amaount){
        return new PeymentCommand(
            PeymentMethod::CreditCard,
            $cardNumber, 
            $cardExpirationDate, 
            $CVC, 
            $cardOwnerFullName,
            $amaount
        );
    }

    function peymentMethod() {return $this->peymentMethod;}
    function creditCartNumber() {return  $this->cardNumber;}
    function creditCartExpirationDate() {return $this->cardExpirationDate;}
    function CVC() {return $this->CVC;}
    function creditCartOwner() {return $this->cardOwnerFullName;}
    function amount() {return $this->amount;}
}