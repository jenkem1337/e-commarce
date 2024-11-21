<?php

enum OrderStatus: string {
    case CREATED = "CREATED";
    case PROCESSING = "PROCESSING";
    case DISPATCHED  = "DISPATCHED";
    case DELIVERED = "DELIVERED";
    case RETURN_REQUEST = "RETURN_REQUEST";
    case RETURNED = "RETURNED";
    case CANCELLED = "CANCELLED";
    
}