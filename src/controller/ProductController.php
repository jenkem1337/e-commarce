<?php
use Ramsey\Uuid\Uuid;
class ProductController {
    private ProductService $productService;
    function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    function createNewProduct(){
        $jsonBody = json_decode(file_get_contents('php://input'));

        $this->productService->craeteNewProduct(
            new ProductCreationalDto(
                Uuid::uuid4(),
                $jsonBody->brand,
                $jsonBody->model,
                $jsonBody->header,
                $jsonBody->description,
                $jsonBody->price,
                $jsonBody->stock_quantity,
                $jsonBody->categories,
                date ('Y-m-d H:i:s'),
                date ('Y-m-d H:i:s')    
            )
        )->onSucsess(function (ProductCreatedResponseDto $response){
            echo json_encode([
                'uuid'=>$response->getUuid(),
                'brand'=> $response->getBrand(),
                'model' => $response->getModel(),
                'header'=>$response->getHeader(),
                'description'=>$response->getDescription(),
                'price'=>$response->getPrice(),
                'stock_quantity'=>$response->getStockQuantity(),
                'categories'=>($response->getCategories()),
                'created_at' => $response->getCreatedAt(),
                'updated_at'=>$response->getUpdatedAt()
            ]);
        })->onError(function (ErrorResponseDto $err){
            echo json_encode([
                'error_message'=>$err->getErrorMessage(),
                'status_code'=> $err->getErrorCode()
            ]);
        });
    }
    function findOneProductByUuid($uuid){
        

        $this->productService->findOneProductByUuid(new FindOneProductByUuidDto($uuid))
                            ->onSucsess(function(OneProductFoundedResponseDto $response){
                                echo json_encode([
                                    'uuid'=>$response->getUuid(),
                                    'brand'=> $response->getBrand(),
                                    'model' => $response->getModel(),
                                    'header'=>$response->getHeader(),
                                    'description'=>$response->getDescription(),
                                    'price'=>$response->getPrice(),
                                    'stock_quantity'=>$response->getStockQuantity(),
                                    'avarage_rate'=>$response->getAvarageRate(),
                                    'comments'=> $response->getComments(),
                                    'rates'=>$response->getRates(),
                                    'subscribers'=>$response->getSubscribers(),
                                    'categories'=> $response->getCategories(),
                                    'images'=>$response->getImages(),
                                    'created_at' => $response->getCreatedAt(),
                                    'updated_at'=>$response->getUpdatedAt()
                                ]);
                            })->onError(function (ErrorResponseDto $err){
                                echo json_encode([
                                    'error_message'=>$err->getErrorMessage(),
                                    'status_code'=> $err->getErrorCode()
                                ]);
                    
                            });
    }

    function updateProductBrandName($uuid){
        $jsonBody = json_decode(file_get_contents('php://input'));
        
        $this->productService->updateProductBrandName(
            new ChangeProductBrandNameDto($uuid, $jsonBody->new_brand_name)
        
        )->onSucsess(function (ProductBrandNameChangedSuccessfullyResponseDto $response){
            echo json_encode(['success_message' => $response->getSuccessMessage()]);
        
        })->onError(function (ErrorResponseDto $err){
            echo json_encode([
                'error_message'=>$err->getErrorMessage(),
                'status_code'=> $err->getErrorCode()
            ]);
        });
    }
}