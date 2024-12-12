<?php

class OrderStatusFactory {

    static function fromValue(string $value):OrderStatus {
        $status = null;

        switch($value) {
            case "CREATED":
                $status = OrderStatus::CREATED;
                break;
            case "PROCESSING":
                $status = OrderStatus::PROCESSING;
                break;
            case "DISPATCHED":
                $status = OrderStatus::DISPATCHED;
                break;
            case "DELIVERED":
                $status = OrderStatus::DELIVERED;
                break;
            case "RETURN_REQUEST":
                $status = OrderStatus::RETURN_REQUEST;
                break;
            case "RETURNED":
                $status = OrderStatus::RETURNED;
                break;
            case "CANCELLED":
                $status = OrderStatus::CANCELLED;
                break;
            default:
                throw new Exception("Unknown status");
        }

        return $status;
    }
}