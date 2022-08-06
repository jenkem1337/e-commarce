<?php
require './vendor/autoload.php';
class ImageController {
    private ProductService $productService;
    function __construct(ProductService $pService)
    {
        $this->productService = $pService;
    }
    function uploadImageForProduct($productUuid){
        $imageArray = array(
            'name' => $_FILES['images']['name'],
            'tmp_name'=> $_FILES['images']['tmp_name']
        );
        $response = $this->productService->uploadImageForProduct(new ImageCreationalDto($imageArray, $productUuid));
        $response->onSucsess(function (ImageCreatedResponseDto $responseDto){
            echo json_encode([
                'images' => $responseDto->getImages()
          ]);
        })->onError(function (ErrorResponseDto $err){
            echo json_encode([
                'error_message' => $err->getErrorMessage(),
                'status_code'=> $err->getErrorCode()
            ]);
        });
    }
}