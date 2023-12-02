<?php
use Predis\Client;
require './vendor/autoload.php';

class FindOneProductByUuidListener implements Listener {
    private ProductService $productService;
    private Client $connection;

    public function __construct(ProductService $productService, Client $conn) {
        $this->productService = $productService;
        $this->connection = $conn;
    }
    function handle(...$params): void
    {
        $response = $this->productService->findOneProductByUuid(new FindOneProductByUuidDto($params[0], [
            "categories"=>false,
            "subscribers"=>false,
            "rates"=>false,
            "images"=>false,
            "comments"=>false,
        ]));
        
        $response->onSucsess(function (OneProductFoundedResponseDto $dto){
            $this->connection->publish("one-product-founded", json_encode(
                [
                    "price" => $dto->getPrice(),
                    "header" => $dto->getHeader(),
                    "hasError" => false,
                    "errorMessage" => ""
                ]
            ));
        })->onError(function(ErrorResponseDto $err){
            $this->connection->publish("one-product-founded", json_encode(
                [
                    "price" => "",
                    "header" => "",
                    "hasError" => true,
                    "errorMessage" => $err->getErrorMessage()
                ]
            ));
    
        });
    }
}