<?php

interface OrderRepository {
    function saveChanges(Order $order);
}