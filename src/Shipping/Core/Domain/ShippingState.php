<?php

enum ShippingState {
    case PENDING;
    case DISPATCHED;
    case DELIVERED;
    case CANCELED;
}