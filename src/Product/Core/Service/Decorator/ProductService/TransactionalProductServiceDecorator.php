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
            return $response;
        }
    }
    function findAllProduct(FindAllProductsDto $dto): ResponseViewModel
    {
            $response = parent::findAllProduct($dto);
            return $response;
    }
    function findAllProductWithPagination(FindAllProductWithPaginationDto $dto): ResponseViewModel
    {
            $response = parent::findAllProductWithPagination($dto);
            return $response;
    }

    function findProductBySearch(FindProductsBySearchDto $dto): ResponseViewModel
    {
            $response = parent::findProductsBySearch($dto);
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
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            return $response;
        }

    }
    function findProductsByPriceRange(FindProductsByPriceRangeDto $dto): ResponseViewModel
    {
            $response = parent::findProductsByPriceRange($dto);
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
            return $response;
        }

    }
    
    function findOneProductByUuid(FindOneProductByUuidDto $dto): ResponseViewModel
    {
        try {
            $response = parent::findOneProductByUuid($dto);
        } catch (\Exception $th) {
            $response = new ErrorResponseDto($th->getMessage(), $th->getCode());
        }

            return $response;

    }
    
    function updateProductDetailsByUuid(ProductDetailDto $dto): ResponseViewModel {
        try {
            $dbConnection = $this->dbConnection->getConnection();
            
            $dbConnection->beginTransaction();
            $response = parent::updateProductDetailsByUuid($dto);
            
            $dbConnection->commit();

        } catch (Exception $e) {
            $dbConnection->rollBack();
            $response = new ErrorResponseDto($e->getMessage(), $e->getCode());
        } finally {
            return $response;
        }
    }

    
}