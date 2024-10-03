<?php

class TransactionalImageServiceDecorator extends ImageServiceDecorator {
    private TransactionalRepository $transactionalRepository;
    function __construct(ImageService $imgService, TransactionalRepository $transactionalRepository)
    {
        $this->transactionalRepository = $transactionalRepository;
        parent::__construct($imgService);
    }
    function uploadImageForProduct(ImageCreationalDto $dto): ResponseViewModel
    {
        try {
            
            $this->transactionalRepository->beginTransaction();
            $response = parent::uploadImageForProduct($dto);
            
            $this->transactionalRepository->commit();
            return $response;

        } catch (Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;
        } 
    }
    function deleteImageByUuid(DeleteImageByUuidDto $dto):ResponseViewModel{
        try {
            
            $this->transactionalRepository->beginTransaction();
            $response = parent::deleteImageByUuid($dto);
            
            $this->transactionalRepository->commit();
            return $response;

        } catch (Exception $e) {
            $this->transactionalRepository->rollBack();
            throw $e;

        } 

    }

}