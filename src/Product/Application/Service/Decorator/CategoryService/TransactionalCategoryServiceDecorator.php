<?php

class TransactionalCategoryServiceDecorator extends CategoryServiceDecorator {
    private TransactionalRepository $transactionalRepository;
    function __construct(CategoryService $service, TransactionalRepository $transactionalRepository)
    {
        $this->transactionalRepository = $transactionalRepository;
        parent::__construct($service);
    }
    function createNewCategory(CategoryCreationalDto $dto): ResponseViewModel
    {
        try {
            
            $this->transactionalRepository->beginTransaction();
            $response = parent::createNewCategory($dto);
            
            $this->transactionalRepository->commit();
            return $response;
        } catch (Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        } 

    }
    function findOneCategoryByUuid(FindCategoryByUuidDto $dto): ResponseViewModel
    {
            return parent::findOneCategoryByUuid($dto);
    }
    function updateCategoryNameByUuid(UpdateCategoryNameByUuidDto $dto): ResponseViewModel
    {
        try {
            
            $this->transactionalRepository->beginTransaction();
            $response = parent::updateCategoryNameByUuid($dto);
            
            $this->transactionalRepository->commit();
            return $response;

        } catch (Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        } 
    }
    function deleteCategoryByUuid(DeleteCategoryDto $dto): ResponseViewModel
    {
        try {
            
            $this->transactionalRepository->beginTransaction();
            $response = parent::deleteCategoryByUuid($dto);
            
            $this->transactionalRepository->commit();
            return $response;

        } catch (Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        } 

    }

}