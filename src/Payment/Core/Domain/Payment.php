<?php

use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
class Payment extends BaseEntity implements PaymentInterface, AggregateRoot {
    private $userUuid;
    private $amount;
    private PaymentMethod $method;
    private PaymentStatus $status;
    private ?PaymentStrategy $paymentStrategy;
    function __construct($uuid, $userUuid, $amount, PaymentMethod $method, PaymentStatus $status, $paymentStrategy, $createdAt, $updatedAt) {
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

    static function newInstance($uuid, $userUuid, $amount, PaymentMethod $method, PaymentStatus $status, $createdAt, $updatedAt):PaymentInterface {
        try {
            return new Payment($uuid, $userUuid, $amount, $method, $status, null, $createdAt, $updatedAt);
        } catch (\Throwable $th) {
            return new NullPayment();
        }
    }

    static function newStrictInstance($uuid, $userUuid, $amount, PaymentMethod $method, PaymentStatus $status, $createdAt, $updatedAt){
        return new Payment($uuid, $userUuid, $amount, $method, $status, null, $createdAt, $updatedAt);
    }

    static function payWithCreditCart($userUuid, $amount, $cardNumber, $cardExpirationDate, $CVC, $cardOwnerFullName): Payment {
        $date = date('Y-m-d H:i:s');
        
        $cart = CreditCart::new($cardNumber, $cardExpirationDate, $CVC, $cardOwnerFullName);
        $payment = new Payment(UUID::uuid4(), $userUuid, $amount, PaymentMethod::CreditCard, PaymentStatus::Pending, $cart,  $date, $date);
        
        $payment->appendLog(new InsertLog("payments", [
            "uuid" => $payment->getUuid(),
            "user_uuid" => $payment->getUserUuid(),
            "amount" => $payment->getAmount(),
            "method" => $payment->getMethod(),
            "status" => $payment->getStatus(),
            "created_at" => $payment->getCreatedAt(),
            "updated_at" => $payment->getUpdatedAt()
        ]));
        return $payment;
    }
    
    function setStatusToCompleted(){
        $this->status = PaymentStatus::Completed;
        $this->appendLog(new UpdateLog("payments", [
            "whereCondation" => [
                "uuid" => $this->getUuid()
            ],
            "setter" => [
                "status" => $this->getStatus(),
                "updated_at" => date('Y-m-d H:i:s')
            ]
        ]));
    }
    function setStatusToRefunded(){
        $this->status = PaymentStatus::Refunded;
        $this->appendLog(new UpdateLog("payments", [
            "whereCondation" => [
                "uuid" => $this->getUuid()
            ],
            "setter" => [
                "status" => $this->getStatus(),
                "updated_at" => date('Y-m-d H:i:s')
            ]
        ]));
    }
    function setStatusToFailed(){
        $this->status = PaymentStatus::Failed;
        $this->appendLog(new UpdateLog("payments", [
            "whereCondation" => [
                "uuid" => $this->getUuid()
            ],
            "setter" => [
                "status" => $this->getStatus(),
                "updated_at" => date('Y-m-d H:i:s')
            ]
        ]));
    }
    function getUserUuid() {return $this->userUuid;}
    function getAmount() {return $this->amount;}
    function getMethod() {return $this->method->name;}
    function getStatus() {return $this->status->name;}
    function getStrategy() {return $this->paymentStrategy;}
}