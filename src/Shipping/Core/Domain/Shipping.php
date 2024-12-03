<?php
use Ramsey\Uuid\Uuid;

class Shipping extends BaseEntity implements AggregateRoot, ShippingInterface {
    private Type $type;
    private ShippingState $state;
    private $addressTitle;
    private $addressOwnerName;
    private $addressOwnerSurname;
    private $fullAddress;
    private $addressCountry;
    private $addressProvince;
    private $addressDistrict;
    private $addressZipCode;

    function __construct($uuid, Type $type, ShippingState $shippingState, $addressTitle,$addressOwnerName,$addressOwnerSurname,$fullAddress,$addressCountry,$addressProvince,$addressDistrict, $addressZipCode,$createdAt, $updatedAt)
    {
        if(!$type) throw new NullException('shipping type');
        $this->type = $type;
        $this->state = $shippingState;
        $this->addressTitle = $addressTitle;
        $this->addressOwnerName = $addressOwnerName;
        $this->addressOwnerSurname = $addressOwnerSurname;
        $this->fullAddress = $fullAddress;
        $this->addressCountry = $addressCountry;
        $this->addressProvince = $addressProvince;
        $this->addressDistrict = $addressDistrict;
        $this->addressZipCode = $addressZipCode;
    
        parent::__construct($uuid, $createdAt, $updatedAt);

    }
    public static function newInstance($uuid, Type $type, ShippingState $shippingState, $addressTitle,$addressOwnerName,$addressOwnerSurname,$fullAddress,$addressCountry,$addressProvince,$addressDistrict, $addressZipCode,$createdAt, $updatedAt):ShippingInterface {
        try {
            return new Shipping($uuid, $type, $shippingState, $addressTitle,$addressOwnerName,$addressOwnerSurname,$fullAddress,$addressCountry,$addressProvince,$addressDistrict, $addressZipCode,$createdAt, $updatedAt);

        } catch (\Throwable $th) {
            return new NullShipping();
        }
    }
    public static function newStrictInstance($uuid, Type $type, ShippingState $shippingState, $addressTitle,$addressOwnerName,$addressOwnerSurname,$fullAddress,$addressCountry,$addressProvince,$addressDistrict, $addressZipCode,$createdAt, $updatedAt):ShippingInterface {
        return new Shipping($uuid,  $type, $shippingState,  $addressTitle,$addressOwnerName,$addressOwnerSurname,$fullAddress,$addressCountry,$addressProvince,$addressDistrict, $addressZipCode,$createdAt, $updatedAt);
    }
    static function newInstanceFromOrderCreation(
        $orderAmount,
        $addressTitle,
        $addressOwnerName,
        $addressOwnerSurname,
        $fullAddress,
        $addressCountry,
        $addressProvince,
        $addressDistrict,
        $addressZipCode
    ):Shipping {
        $date =  date('Y-m-d H:i:s');
        $shipping =  new Shipping(UUID::uuid4(), Type::fromOrderAmount($orderAmount), ShippingState::PENDING, $addressTitle,$addressOwnerName,$addressOwnerSurname,$fullAddress,$addressCountry,$addressProvince,$addressDistrict,$addressZipCode, $date, $date);
        
        $shipping->appendLog(new InsertLog("shipments", [
            "uuid" => $shipping->getUuid(),
            "type" => $shipping->getShippingType()->getType(),
            "status" => $shipping->getShippingState(),
            "address_title" => $shipping->getAddressTitle(),
            "address_owner_name" => $shipping->getAddressOwnerName(),
            "address_owner_surname" => $shipping->getAddressOwnerSurname(),
            "full_address" => $shipping->getFullAddress(),
            "address_country" => $shipping->getAddressCountry(),
            "address_province" => $shipping->getAddressProvince(),
            "address_district" => $shipping->getAddressDistrict(),
            "address_zipcode" => $shipping->getAddressZipCode(),
            "created_at" => $shipping->getCreatedAt(),
            "updated_at" => $shipping->getUpdatedAt()
        ]));
        return $shipping;
    }
    
    function setStatusToDispatched() {
        $this->state = ShippingState::DISPATCHED;
        $this->appendLog(new UpdateLog("shipments", [
            "whereCondation" => ["uuid" => $this->getUuid()],
            "setter" => [
                "status" => $this->getShippingState(),
                "updated_at" => date('Y-m-d H:i:s')
            ]
        ]));

    }

    function setStateToDelivered() {
        $this->state = ShippingState::DELIVERED;
        $this->appendLog(new UpdateLog("shipments", [
            "whereCondation" => ["uuid" => $this->getUuid()],
            "setter" => [
                "status" => $this->getShippingState(),
                "updated_at" => date('Y-m-d H:i:s')
            ]
        ]));

    }

    function setStatusToCanceled(){
        $this->state = ShippingState::CANCELED;
        $this->appendLog(new UpdateLog("shipments", [
            "whereCondation" => ["uuid" => $this->getUuid()],
            "setter" => [
                "status" => $this->getShippingState(),
                "updated_at" => date('Y-m-d H:i:s')
            ]
        ]));
    }
    
    function isDelivered() {
        if($this->state !== ShippingState::DELIVERED) {
            throw new ShippingHasNotDeliveredException();
        }
    }
    public function getShippingType(): Type
    {
        return $this->type;
    }


    /**
     * Get the value of shippingState
     */ 
    public function getShippingState()
    {
        return $this->state->name;
    }


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