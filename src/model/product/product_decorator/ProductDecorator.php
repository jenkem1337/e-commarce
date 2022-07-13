<?php 
require './vendor/autoload.php';

abstract class ProductDecorator extends Product implements ProductInterface, AggregateRoot{
    function __construct($uuid, string $brand,string $model,string $header, string $description, float $price,int $stockQuantity,RateInterface $rate,$createdAt, $updatedAt)
    {

        parent::__construct($uuid, $brand, $model, $header,  $description,  $price, $stockQuantity, $rate,$createdAt, $updatedAt);
    }
}