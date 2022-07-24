<?php 
require './vendor/autoload.php';

abstract class ProductDecorator extends Product{
    function __construct($uuid, string $brand,string $model,string $header, string $description, float $price,int $stockQuantity,$createdAt, $updatedAt)
    {

        parent::__construct($uuid, $brand, $model, $header,  $description,  $price, $stockQuantity,$createdAt, $updatedAt);
    }
}