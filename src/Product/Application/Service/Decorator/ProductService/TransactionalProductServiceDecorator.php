<?php

class TransactionalProductServiceDecorator extends ProductServiceDecorator {
    private TransactionalRepository $transactionalRepository;
    function __construct(ProductService $productService, TransactionalRepository $transactionalRepository)
    {
        $this->transactionalRepository = $transactionalRepository;
        parent::__construct($productService);
    }
    function craeteNewProduct(ProductCreationalDto $dto): ResponseViewModel
    {
        try {
            
            $this->transactionalRepository->beginTransaction();
            $response = parent::craeteNewProduct($dto);
            
            $this->transactionalRepository->commit();
            return $response;
        } catch (Exception $e) {
            $this->transactionalRepository->rollback();
            throw $e;
        } 
    }
    function findProductsByCriteria(FindProductsByCriteriaDto $dto): ResponseViewModel
    {
            $response = parent::findProductsByCriteria($dto);
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
            
            $this->transactionalRepository->beginTransaction();
            $response = parent::createNewProductSubscriber($dto);
            
            $this->transactionalRepository->commit();
            return $response;
        } catch (Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        } 

    }

    function updateProductStockQuantity(ChangeProductStockQuantityDto $dto): ResponseViewModel
    {
        try {
            
            $this->transactionalRepository->beginTransaction();
            $response = parent::updateProductStockQuantity($dto);
            
            $this->transactionalRepository->commit();
            return $response;
        } catch (Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        } 

    }
    function deleteProduct(DeleteProductByUuidDto $dto): ResponseViewModel
    {
        try {
            
            $this->transactionalRepository->beginTransaction();
            $response = parent::deleteProduct($dto);
            
            $this->transactionalRepository->commit();
            return $response;
        } catch (Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        } 

    }

    function deleteProductSubscriber(DeleteProductSubscriberDto $dto): ResponseViewModel
    {
        try {
            
            $this->transactionalRepository->beginTransaction();
            $response = parent::deleteProductSubscriber($dto);
            
            $this->transactionalRepository->commit();
            return $response;

        } catch (Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        } 

    }
    
    function findOneProductByUuid(FindOneProductByUuidDto $dto): ResponseViewModel
    {
        try {
            $response = parent::findOneProductByUuid($dto);
            return $response;

        } catch (\Exception $th) {
            throw $th;
        }


    }
    
    function updateProductDetailsByUuid(ProductDetailDto $dto): ResponseViewModel {
        try {
            
            $this->transactionalRepository->beginTransaction();
            $response = parent::updateProductDetailsByUuid($dto);
            
            $this->transactionalRepository->commit();
            return $response;
        } catch (Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        } 
    }

    function checkQuantityAndDecrease(CheckAndDecreaseProductsDto $dto): ResponseViewModel {
        return parent::checkQuantityAndDecrease($dto);
    }
    function reviewProduct(ProductReviewDto $dto): ResponseViewModel{
        try {
            
            $this->transactionalRepository->beginTransaction();
            $response = parent::reviewProduct($dto);
            
            $this->transactionalRepository->commit();
            return $response;
        } catch (Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        } 

    }
    function updateProductComment(UpdateProductCommentDto $dto): ResponseViewModel{
        try {
            
            $this->transactionalRepository->beginTransaction();
            $response = parent::updateProductComment($dto);
            
            $this->transactionalRepository->commit();
            return $response;
        } catch (Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        } 

    }
    function updateProductRate(UpdateProductRateDto $dto): ResponseViewModel{
        try {
            
            $this->transactionalRepository->beginTransaction();
            $response = parent::updateProductRate($dto);
            
            $this->transactionalRepository->commit();
            return $response;
        } catch (Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        } 

    }
    function deleteProductReview(DeleteProductReviewDto $dto): ResponseViewModel{
        try {
            
            $this->transactionalRepository->beginTransaction();
            $response = parent::deleteProductReview($dto);
            
            $this->transactionalRepository->commit();
            return $response;
        } catch (Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        } 

    }
}