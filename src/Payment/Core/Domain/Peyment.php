<?php

use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
class Peyment extends BaseEntity implements PeymentInterface, AggregateRoot {
    private $userUuid;
    private $amount;
    private $method;
    private PeymentStatus $status;
    function __construct($uuid, $userUuid, $amount, $method, PeymentStatus $status, $createdAt, $updatedAt) {
        parent::__construct($uuid, $createdAt, $updatedAt);
        if(!$userUuid) throw new NullException("user uuid");
        if(!UUID::isValid($userUuid)) throw new InvalidUuidStringException("user uuid invalid");
        if($amount < 0) throw new NegativeValueException();
        if(!$method || trim($method) == "") throw new NullException("method");
        if(!$status) throw new NullException("status");

        $this->userUuid = $userUuid;
        $this->amount = $amount;
        $this->method = $method;
        $this->status = $status;
    }

    static function newInstance($uuid, $userUuid, $amount, $method, PeymentStatus $status, $createdAt, $updatedAt):PeymentInterface {
        try {
            return new Peyment($uuid, $userUuid, $amount, $method, $status, $createdAt, $updatedAt);
        } catch (\Throwable $th) {
            return new NullPeyment();
        }
    }

    static function newStrictInstance($uuid, $userUuid, $amount, $method, PeymentStatus $status, $createdAt, $updatedAt){
        return new Peyment($uuid, $userUuid, $amount, $method, $status, $createdAt, $updatedAt);
    }

    static function createNewPeyment($userUuid, $amount, $method):PeymentInterface {
        $date = date('Y-m-d H:i:s');
        $peyment = new Peyment(UUID::uuid4(), $userUuid, $amount, $method, PeymentStatus::Pending, $date, $date);
        $peyment->appendLog(new InsertLog("peyments", [
            "uuid" => $peyment->getUuid(),
            "user_uuid" => $peyment->getUserUuid(),
            "amount" => $peyment->getAmount(),
            "method" => $peyment->getMethod(),
            "status" => $peyment->getStatus(),
            "created_at" => $peyment->getCreatedAt(),
            "updated_at" => $peyment->getUpdatedAt()
        ]));
        return $peyment;
    }

    function processPeyment(PeymentCommand $peymentCommand){
        $peymentMethod = null;
        switch($this->getMethod()) {
            case PeymentMethod::CreditCard: 
                $peymentCommand = $this->payWithCreditCart(
                    $peymentCommand->creditCartNumber(),
                    $peymentCommand->creditCartExpirationDate(),
                    $peymentCommand->CVC(),
                    $peymentCommand->creditCartOwner()
                );
                break;
            
            default:
                throw new InvalidPeymentMethodExepction();
        }
        return $peymentMethod;
    }
    private function payWithCreditCart($cardNumber, $cardExpirationDate, $CVC, $cardOwnerFullName) {
        $cart = CreditCart::new($cardNumber, $cardExpirationDate, $CVC, $cardOwnerFullName);
        $cart->checkCart();
        return $cart;
    }
    
    function setStatusToCompleted(){
        $this->status = PeymentStatus::Completed;
        $this->appendLog(new UpdateLog("peyments", [
            "whereCondation" => [
                "uuid" => $this->getUuid()
            ],
            "setter" => [
                "status" => $this->status
            ]
        ]));
    }
    function setStatusToRefunded(){
        $this->status = PeymentStatus::Refunded;
        $this->appendLog(new UpdateLog("peyments", [
            "whereCondation" => [
                "uuid" => $this->getUuid()
            ],
            "setter" => [
                "status" => $this->status
            ]
        ]));
    }
    function setStatusToFailed(){
        $this->status = PeymentStatus::Failed;
        $this->appendLog(new UpdateLog("peyments", [
            "whereCondation" => [
                "uuid" => $this->getUuid()
            ],
            "setter" => [
                "status" => $this->status
            ]
        ]));
    }
    function getUserUuid() {return $this->userUuid;}
    function getAmount() {return $this->amount;}
    function getMethod() {return $this->method;}
    function getStatus() {return $this->status;}
}