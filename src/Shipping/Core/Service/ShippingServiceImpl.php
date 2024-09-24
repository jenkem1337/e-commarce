<?php

class ShippingServiceImpl implements ShippingService {
    private ShippingRepository $shippingRepository;
    function __construct(ShippingRepository $shippingRepo)
    {
        $this->shippingRepository = $shippingRepo;
    }
    function findAll(FindAllShippingMethodDto $dto): ResponseViewModel
    {
        $shippings = $this->shippingRepository->findAll();
        return new SuccessResponse([
            "data" => $shippings->getIterator()
        ]);
    }
    function findOneByUuid(FindOneShippingMethodDto $dto): ResponseViewModel
    {
        $shippingDomainModel = $this->shippingRepository->findOneByUuid($dto->getUuid());
        if($shippingDomainModel->isNull()) throw new NotFoundException('shipping');
        return new SuccessResponse([
            "message" => "A shipping founded",
            "data" => [
                "uuid" => $shippingDomainModel->getUuid(),
                "shipping_type" => $shippingDomainModel->getShippingType(),
                "price" => $shippingDomainModel->getPrice(),
                "created_at" => $shippingDomainModel->getCreatedAt(),
                "updated_at" => $shippingDomainModel->getUpdatedAt()
    
            ]
        ]);
    }
}