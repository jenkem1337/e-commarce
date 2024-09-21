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
            echo json_encode($response);
        })->onError(function (ErrorResponseDto $err){
            echo json_encode($err);    
            http_response_code($err->getErrorCode());
        });
    }
    function createNewProductSubscriber($productUuid){
        $jwtPayload = JwtPayloadDto::getInstance();
        $userDetail = $jwtPayload->getPayload();
        $jwtPayload->removePayload();
        
        $this->productService->createNewProductSubscriber(
            new ProductSubscriberCreationalDto(
                Uuid::uuid4(),
                $productUuid,
                $userDetail->user_uuid,
                date ('Y-m-d H:i:s'),
                date ('Y-m-d H:i:s')
            )
        )->onSucsess(function (ProductSubscriberCreatedResponseDto $response){
            echo json_encode($response);
        })->onError(function (ErrorResponseDto $err){
            echo json_encode($err);    
            http_response_code($err->getErrorCode());
        });
    }
    function deleteProduct($uuid){
        $this->productService->deleteProduct(new DeleteProductByUuidDto($uuid))
                            ->onSucsess(function (ProductDeletedResponseDto $response){
                                echo json_encode($response);
                            })->onError(function (ErrorResponseDto $err){
                                echo json_encode($err);    
                                http_response_code($err->getErrorCode());
                            });
    }
    function deleteProductSubscriber($productUuid) {
        $jwtPayload = JwtPayloadDto::getInstance();
        $userDetail = $jwtPayload->getPayload();
        $jwtPayload->removePayload();
        
        $this->productService->deleteProductSubscriber(new DeleteProductSubscriberDto($productUuid, $userDetail->user_uuid))
                            ->onSucsess(function (ProductSubscriberDeletedResponseDto $response){
                                echo json_encode($response);
                            })->onError(function (ErrorResponseDto $err){
                                echo json_encode($err);    
                                http_response_code($err->getErrorCode());
                            });

    }
    function findProductsByCriteria() {
        $jsonBody = json_decode(file_get_contents('php://input'));
        
        $pageNum = isset($_GET['page']) ? $_GET['page'] : 1;
        $perPageForProduct = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
    
        $comments       = isset($jsonBody->comments)    ? $jsonBody->comments : false;
        $images         = isset($jsonBody->images)      ? $jsonBody->images : false;
        $subscribers    = isset($jsonBody->subscribers) ? $jsonBody->subscribers: false;
        $categories     = isset($jsonBody->categories)  ? $jsonBody->categories : false;
        $rates          = isset($jsonBody->rates)       ? $jsonBody->rates : false;
        $filterArray = array(
            "comments"=>$comments,
            "images"=>$images,
            "subscribers"=> $subscribers,
            "categories"=> $categories,
            "rates"=> $rates
        );
        $this->productService->findProductsByCriteria(new FindProductsByCriteriaDto($jsonBody->specific_categories, $jsonBody->price_lower_bound, $jsonBody->price_upper_bound, $jsonBody->rate_lower_bound, $jsonBody->rate_upper_bound, $perPageForProduct, $pageNum, $filterArray ))
                            ->onSucsess(function (AllProductResponseDto $response){
                                echo json_encode($response);
                            })->onError(function (ErrorResponseDto $err){
                                echo json_encode($err);    
                                http_response_code($err->getErrorCode());                                        
                            });
   }
   function findProductsBySearch(){
    $pageNum = isset($_GET['page']) ? $_GET['page'] : 1;
    $perPageForProduct = isset($_GET['per_page']) ? $_GET['per_page'] : 10;

    $searchValue = isset($_GET['search_val']) ? $_GET['search_val'] : '';
    $comments = isset($_GET['comments'])       ? $_GET['comments'] : "dont_get";
    $images = isset($_GET['images'])           ? $_GET['images'] : "dont_get";
    $subscribers = isset($_GET['subscribers']) ? $_GET['subscribers'] : "dont_get";
    $categories = isset($_GET['categories'])   ? $_GET['categories'] : "dont_get";
    $rates = isset($_GET['rates'])             ? $_GET['rates'] : "dont_get";
    $filterArray = array(
        "comments"=>$comments,
        "images"=>$images,
        "subscribers"=> $subscribers,
        "categories"=> $categories,
        "rates"=> $rates
    );

    $this->productService->findProductsBySearch(new FindProductsBySearchDto($searchValue, $perPageForProduct, $pageNum, $filterArray))
                        ->onSucsess(function (SearchedProductResponseDto $response){
                                echo json_encode($response);
                        })->onError(function (ErrorResponseDto $err) {
                            echo json_encode($err);    
                            http_response_code($err->getErrorCode());                                        
                        });

   }
   function findOneProductByUuid($uuid){
        $comments = isset($_GET['comments'])       ? $_GET['comments'] : "dont_get";
        $images = isset($_GET['images'])           ? $_GET['images'] : "dont_get";
        $subscribers = isset($_GET['subscribers']) ? $_GET['subscribers'] : "dont_get";
        $categories = isset($_GET['categories'])   ? $_GET['categories'] : "dont_get";
        $rates = isset($_GET['rates'])             ? $_GET['rates'] : "dont_get";
        $filterArray = array(
            "comments"=>$comments,
            "images"=>$images,
            "subscribers"=> $subscribers,
            "categories"=> $categories,
            "rates"=> $rates
        );

       $this->productService->findOneProductByUuid(new FindOneProductByUuidDto($uuid, $filterArray))
                            ->onSucsess(function(OneProductFoundedResponseDto $response){
                                echo json_encode($response);
                            })->onError(function (ErrorResponseDto $err){
                                echo json_encode($err);    
                                http_response_code($err->getErrorCode());                                                
                            });
        
    }

    function updateProductDetails($productUuid){
        $jsonBody = json_decode(file_get_contents('php://input'));
        $this->productService->updateProductDetailsByUuid(new ProductDetailDto($productUuid, $jsonBody->brand, $jsonBody->model, $jsonBody->header, $jsonBody->description, $jsonBody->price))
                            ->onSucsess(function (ProductDetailsChangedResponseDto $response) {
                                echo json_encode($response);
                            })->onError(function (ErrorResponseDto $err){
                                echo json_encode($err);    
                                http_response_code($err->getErrorCode());                                        
                            });
    }
    function updateProductStockQuantity($productUuid){
        $jsonBody = json_decode(file_get_contents('php://input'));

        $this->productService->updateProductStockQuantity(new ChangeProductStockQuantityDto($productUuid, $jsonBody->new_stock_quantity, $jsonBody->update_event_constant))
                            ->onSucsess(function (ProductStockQuantityChangedResponseDto $response){
                                echo json_encode($response);
                            
                            })->onError(function (ErrorResponseDto $err){
                                echo json_encode($err);    
                                http_response_code($err->getErrorCode());                                        
                            });
    }
}
