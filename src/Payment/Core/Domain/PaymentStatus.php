<?php
enum PaymentStatus {
    case Pending;
    case Completed;
    case Failed;
    case Refunded;
}