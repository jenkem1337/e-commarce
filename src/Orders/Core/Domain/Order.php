<?php
use Ramsey\Uuid\Uuid;
class Order extends BaseEntity implements AggregateRoot, OrderInterface {
    private $userUuid;
    private $paymentUuid;
    private $shippingUuid;
    private $amount;
    private OrderStatus $status;
    private OrderItemCollection $items;
    private function __construct(
        $uuid,
        $userUuid, 
        $amount,
        $orderStatus,
        $createdAt, 
        $updatedAt){
            parent::__construct($uuid, $createdAt, $updatedAt);

            $this->userUuid = $userUuid;
            $this->amount = $amount;
            $this->status = $orderStatus;
            $this->items = new OrderItemCollection();
    }

    static function placeOrder($userUuid, $amount, $orderItems){
        $timestamp = date('Y-m-d H:i:s');
        $order = new Order(UUID::uuid4(),$userUuid, $amount, OrderStatus::CREATED, $timestamp, $timestamp);
        $order->appendLog(new InsertLog("orders", [
            "uuid" => $order->getUuid(),
            "user_uuid" => $order->getUserUuid(),
            "amount" => $order->getAmount(),
            "status" => $order->getStatus(),
            "created_at" => $order->getCreatedAt(),
            "updated_at" => $order->getUpdatedAt()
        ]));
        $order->appendItems($orderItems);
        return $order;
    }
    
    function appendItems($items) {
        foreach($items as $item) {
            
            $timestamp = date('Y-m-d H:i:s');
            
            $orderItem = OrderItem::newStrictInsatance(UUID::uuid4(), $this->getUuid(), $item->productUuid, $item->quantity, $timestamp, $timestamp);
            
            $this->items->add($orderItem);
            
            $this->appendLog(new InsertLog("order_items", [
                "uuid" => $orderItem->getUuid(),
                "order_uuid" => $orderItem->getOrderUuid(),
                "product_uuid" => $orderItem->getProductUuid(),
                "quantity" => $orderItem->getQuantity(),
                "created_at" => $orderItem->getCreatedAt(),
                "updated_at" => $orderItem->getUpdatedAt()
            ]));
        }
    }
    function determineLatestAmount($shippingPrice) {
        $this->amount = $this->amount + $shippingPrice;
    }
    function setStateToProcessingAndAssignPaymentAndShippingUuid($paymentUuid, $shippingUuid){
        if(!$paymentUuid) throw new NullException("payment uuid");
        $this->paymentUuid = $paymentUuid;
        
        if(!$shippingUuid) throw new NullException("shipment uuid");
        $this->shippingUuid = $shippingUuid;

        $this->status = OrderStatus::PROCESSING;

        $this->appendLog(new UpdateLog("orders", [
            "whereCondation" => ["uuid" => $this->getUuid()],
            "setter" => [
                "payment_uuid" => $this->getPaymentUuid(),
                "shipment_uuid" => $this->getShippingUuid(),
                "amount" => $this->getAmount(),
                "status" => $this->getStatus()
            ]
        ]));
    }

    function setStatusToDelivered(){
        $this->status = OrderStatus::DELIVERED;

        $this->appendLog(new UpdateLog("orders", [
            "whereCondation" => ["uuid" => $this->getUuid()],
            "setter" => [
                "status" => $this->getStatus()
            ]
        ]));
    }
    /**
     * Get the value of userUuid
     */ 
    public function getUserUuid()
    {
            return $this->userUuid;
    }
    /**
     * Get the value of paymentUuid
     */ 
    public function getPaymentUuid()
    {
            return $this->paymentUuid;
    }
    /**
     * Get the value of shippingUuid
     */ 
    public function getShippingUuid()
    {
            return $this->shippingUuid;
    }

    /**
     * Get the value of amount
     */ 
    public function getAmount()
    {
        return $this->amount;
    }

  
    /**
     * Get the value of status
     */ 
    public function getStatus(): string
    {
        return $this->status->value;
    }

    /**
     * Get the value of items
     */ 
    public function getItems(): OrderItemCollection
    {
        return $this->items;
    }
}