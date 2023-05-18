<?php

class TransactionalProductServiceDecorator extends ProductServiceDecorator {
    private DatabaseConnection $dbConnection;
    function __construct(ProductService $productService, DatabaseConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
        parent::__construct($productService);
    }
    function craeteNewProduct(ProductCreationalDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::craeteNewProduct($dto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            $this->dbConnection->closeConnection();
            $dbConnection = null;
            return $response;
        }
    }
    function findAllProduct(FindAllProductsDto $dto): ResponseViewModel
    {
            $response = parent::findAllProduct($dto);
            
            $this->dbConnection->closeConnection();

            return $response;
    }
    function findAllProductWithPagination(FindAllProductWithPaginationDto $dto): ResponseViewModel
    {
            $response = parent::findAllProductWithPagination($dto);
            
            $this->dbConnection->closeConnection();

            return $response;
    }

    function findProductBySearch(FindProductsBySearchDto $dto): ResponseViewModel
    {
            $response = parent::findProductsBySearch($dto);
            
            $this->dbConnection->closeConnection();

            return $response;

    }
    function createNewProductSubscriber(ProductSubscriberCreationalDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::createNewProductSubscriber($dto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $this->dbConnection->closeConnection();
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            $dbConnection = null;
            return $response;
        }

    }
    function findProductsByPriceRange(FindProductsByPriceRangeDto $dto): ResponseViewModel
    {
            $response = parent::findProductsByPriceRange($dto);
            
            $this->dbConnection->closeConnection();
            return $response;
        
    }

    function updateProductStockQuantity(ChangeProductStockQuantityDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::updateProductStockQuantity($dto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            $this->dbConnection->closeConnection();
            $dbConnection = null;
            return $response;
        }

    }
    function deleteProduct(DeleteProductByUuidDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::deleteProduct($dto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            $this->dbConnection->closeConnection();
            $dbConnection = null;
            return $response;
        }

    }

    function deleteProductSubscriber(DeleteProductSubscriberDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::deleteProductSubscriber($dto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            $this->dbConnection->closeConnection();
            $dbConnection = null;
            return $response;
        }

    }
    function updateProductBrandName(ChangeProductBrandNameDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::updateProductBrandName($dto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            $this->dbConnection->closeConnection();

            $dbConnection = null;
            return $response;
        }

    }
    function findOneProductByUuid(FindOneProductByUuidDto $dto): ResponseViewModel
    {
            $response = parent::findOneProductByUuid($dto);
            
            $this->dbConnection->closeConnection();

            return $response;

    }
    
    function updateProductModelName(ChangeProductModelNameDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::updateProductModelName($dto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            $this->dbConnection->closeConnection();

            $dbConnection = null;
            return $response;
        }

    }
    function updateProductHeader(ChangeProductHeaderDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::updateProductHeader($dto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            $this->dbConnection->closeConnection();

            $dbConnection = null;
            return $response;
        }

    }
    function updateProductDescription(ChangeProductDescriptionDto $dto): ResponseViewModel
    {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::updateProductDescription($dto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            $this->dbConnection->closeConnection();

            $dbConnection = null;
            return $response;
        }
    }
        function updateProductPrice(ChangeProductPriceDto $dto): ResponseViewModel
        {
            try {
                $dbConnection = $this->dbConnection->getConnection();
                
                $dbConnection->beginTransaction();
                $response = parent::updateProductPrice($dto);
                
                $dbConnection->commit();
    
            } catch (Exception $e) {
                $dbConnection->rollBack();
                $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
            } finally {
                $this->dbConnection->closeConnection();

                $dbConnection = null;
                return $response;
            }
    
        }

    
}