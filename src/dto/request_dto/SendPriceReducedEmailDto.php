<?php
class SendPriceReducedEmailDto{
    private $fullName;
    private $email;
    private $productUuid;
    private $actualPrice;
    private $oldPrice;

    function __construct(
        $fullName,
        $email,
        $productUuid,
        $actualPrice,
        $oldPrice
    ){
        $this->fullName = $fullName;
        $this->email = $email;
        $this->productUuid = $productUuid;
        $this->actualPrice = $actualPrice;
        $this->oldPrice = $oldPrice;
    }
    function getFullName(){return $this->fullName;}
    function getEmail(){return $this->email;}
    function getProductUuid(){return $this->productUuid;}
    function getActualPrice(){return $this->actualPrice;}
    function getOldPrice(){return $this->oldPrice;}

}