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
            "data" => $shippings
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
                "type" => $shippingDomainModel->getShippingType()->getType(),
                "price" => $shippingDomainModel->getShippingType()->getPrice(),
                "created_at" => $shippingDomainModel->getCreatedAt(),
                "updated_at" => $shippingDomainModel->getUpdatedAt()
    
            ]
        ]);
    }

    function createShippingForOrderCreation(CreationalShippingDto $dto): ResponseViewModel{
        $shipping = Shipping::newInstanceFromOrderCreation(
            $dto->getOrderAmount(),
            $dto->getAddressTitle(),
            $dto->getAddressOwnerName(),
            $dto->getAddressOwnerSurname(),
            $dto->getFullAddress(),
            $dto->getAddressCountry(),
            $dto->getAddressProvince(),
            $dto->getAddressDistrict(),
            $dto->getAddressZipCode()
        );

        $this->shippingRepository->saveChanges($shipping);

        return new SuccessResponse([
            "data" => [
                "uuid" => $shipping->getUuid(),
                "price" => $shipping->getShippingType()->getPrice()
            ]
        ]);
    }
}