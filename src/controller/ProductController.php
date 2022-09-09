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
    function findAllProducts() {
        $this->productService->findAllProduct(new FindAllProductsDto)
                            ->onSucsess(function (AllProductResponseDto $response){
                                echo json_encode($response);
                            })->onError(function (ErrorResponseDto $err){
                                echo json_encode($err);    
                                http_response_code($err->getErrorCode());                                        
                            });
   }
   function findAllProductWithPagination() {
        $pageNum = isset($_GET['page']) ? $_GET['page'] : 1;
        $perPageForProduct = 10;
        $this->productService->findAllProductWithPagination(new FindAllProductWithPaginationDto($perPageForProduct, $pageNum))
                            ->onSucsess(function (AllProductWithPaginationResponseDto $response){
                                echo json_encode($response);
                            })->onError(function (ErrorResponseDto $err) {
                                echo json_encode($err);    
                                http_response_code($err->getErrorCode());                                        
                            });
   }
   function findProductsBySearch(){
    $pageNum = isset($_GET['page']) ? $_GET['page'] : 1;
    $searchValue = isset($_GET['search_val']) ? $_GET['search_val'] : '';
    $perPageForProduct = 10;
    $this->productService->findProductsBySearch(new FindProductsBySearchDto($searchValue, $perPageForProduct, $pageNum))
                        ->onSucsess(function (SearchedProductResponseDto $response){
                                echo json_encode($response);
                        })->onError(function (ErrorResponseDto $err) {
                            echo json_encode($err);    
                            http_response_code($err->getErrorCode());                                        
                        });

   }
   function findOneProductByUuid($uuid){
        
       $this->productService->findOneProductByUuid(new FindOneProductByUuidDto($uuid))
                            ->onSucsess(function(OneProductFoundedResponseDto $response){
                                echo json_encode($response);
                            })->onError(function (ErrorResponseDto $err){
                                echo json_encode($err);    
                                http_response_code($err->getErrorCode());                                                
                            });
        
    }

    function updateProductBrandName($uuid){
        $jsonBody = json_decode(file_get_contents('php://input'));
        
        $this->productService->updateProductBrandName(new ChangeProductBrandNameDto($uuid, $jsonBody->new_brand_name))
                            ->onSucsess(function (ProductBrandNameChangedSuccessfullyResponseDto $response){
                                echo json_encode($response);
                            
                            })->onError(function (ErrorResponseDto $err){
                                echo json_encode($err);    
                                http_response_code($err->getErrorCode());                                        
                            });
    }

    function updateProductModelName($uuid){
        $jsonBody = json_decode(file_get_contents('php://input'));
        
        $this->productService->updateProductModelName(new ChangeProductModelNameDto($uuid, $jsonBody->new_model_name))
                            ->onSucsess(function (ProductModelNameChangedResponseDto $response){
                                echo json_encode($response);
                            })->onError(function (ErrorResponseDto $err){
                                echo json_encode($err);    
                                http_response_code($err->getErrorCode());                                        
                            });
    }
    function updateProductHeader($uuid){
        $jsonBody = json_decode(file_get_contents('php://input'));
        
        $this->productService->updateProductHeader(new ChangeProductHeaderDto($uuid, $jsonBody->new_header))
                            ->onSucsess(function (ProductHeaderChangedResponseDto $response){
                                echo json_encode($response);
                            })->onError(function (ErrorResponseDto $err){
                                echo json_encode($err);    
                                http_response_code($err->getErrorCode());                                        
                            });

    }
    function updateProductDescription($uuid){
        $jsonBody = json_decode(file_get_contents('php://input'));
        
        $this->productService->updateProductDescription(new ChangeProductDescriptionDto($uuid, $jsonBody->new_description))
                            ->onSucsess(function (ProductDescriptionChangedResponseDto $response){
                                echo json_encode($response);
                            
                            })->onError(function (ErrorResponseDto $err){
                                echo json_encode($err);    
                                http_response_code($err->getErrorCode());                                        
                            });

    }

    function updateProductPrice($uuid) {
        $jsonBody = json_decode(file_get_contents('php://input'));
        
        $this->productService->updateProductPrice(new ChangeProductPriceDto($uuid, $jsonBody->new_price))
                            ->onSucsess(function (ProductPriceChangedResponseDto $response){
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
    function findProductByPriceRange(){
        $from = isset($_GET['from']) ? $_GET['from'] : '';
        $to = isset($_GET['to']) ? $_GET['to'] : '';
        $this->productService->findProductsByPriceRange(new FindProductsByPriceRangeDto($from, $to))
                            ->onSucsess(function (AllProductResponseDto $response){
                                echo json_encode($response);
                            })->onError(function (ErrorResponseDto $err){
                                echo json_encode($err);    
                                http_response_code($err->getErrorCode());
                            });
    }
}
