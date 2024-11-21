<?php

use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
class Payment extends BaseEntity implements PaymentInterface, AggregateRoot {
    private $userUuid;
    private $amount;
    private PaymentMethod $method;
    private PaymentStatus $status;
    private PaymentStrategy $paymentStrategy;
    function __construct($uuid, $userUuid, $amount, $method, PaymentStatus $status, $paymentStrategy, $createdAt, $updatedAt) {
        parent::__construct($uuid, $createdAt, $updatedAt);
        if(!$userUuid) throw new NullException("user uuid");
        if(!UUID::isValid($userUuid)) throw new InvalidUuidStringException("user uuid invalid");
        if($amount < 0) throw new NegativeValueException();
        if(!$method) throw new NullException("method");
        if(!$status) throw new NullException("status");

        $this->userUuid = $userUuid;
        $this->amount = $amount;
        $this->method = $method;
        $this->paymentStrategy = $paymentStrategy;
        $this->status = $status;
    }

    static function newInstance($uuid, $userUuid, $amount, $method, PaymentStatus $status, $createdAt, $updatedAt):PaymentInterface {
        try {
            return new Payment($uuid, $userUuid, $amount, $method, $status, null, $createdAt, $updatedAt);
        } catch (\Throwable $th) {
            return new NullPayment();
        }
    }

    static function newStrictInstance($uuid, $userUuid, $amount, $method, PaymentStatus $status, $createdAt, $updatedAt){
        return new Payment($uuid, $userUuid, $amount, $method, $status, null, $createdAt, $updatedAt);
    }

    static function payWithCreditCart($userUuid, $amount, $cardNumber, $cardExpirationDate, $CVC, $cardOwnerFullName): Payment {
        $date = date('Y-m-d H:i:s');
        
        $cart = CreditCart::new($cardNumber, $cardExpirationDate, $CVC, $cardOwnerFullName);
        $peyment = new Payment(UUID::uuid4(), $userUuid, $amount, PaymentMethod::CreditCard, PaymentStatus::Pending, $cart,  $date, $date);
        
        $peyment->appendLog(new InsertLog("payments", [
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
    
    function setStatusToCompleted(){
        $this->status = PaymentStatus::Completed;
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
        $this->status = PaymentStatus::Refunded;
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
        $this->status = PaymentStatus::Failed;
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
    function getMethod() {return $this->method->value;}
    function getStatus() {return $this->status->value;}
    function getStrategy() {return $this->paymentStrategy;}
}