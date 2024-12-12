<?php

class PaymentStatusFactory {
    static function fromValue(string $value):PaymentStatus {
        $status = null;

        switch ($value) {
            case "Pending":
                $status = PaymentStatus::Pending;
                break;
            case "Completed":
                $status = PaymentStatus::Completed;
                break;
            case "Failed":
                $status = PaymentStatus::Failed;
                break;
            case "Refunded":
                $status = PaymentStatus::Refunded;
                break;
            default: throw new Exception("Unknown status");
        }
        return $status;
    }
}