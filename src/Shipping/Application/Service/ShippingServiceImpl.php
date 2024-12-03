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

    function setStateToDispatched(ShippingStatusDto $dto) {
        $shipmentAggregate = $this->shippingRepository->findOneByUuid($dto->getUuid());
        
        if($shipmentAggregate->isNull()) throw new NotFoundException("shippiment");

        $shipmentAggregate->setStatusToDispatched();

        $this->shippingRepository->saveChanges($shipmentAggregate);
    }

    function setStateToDelivered(ShippingStatusDto $dto):ResponseViewModel{
        $shipmentAggregate = $this->shippingRepository->findOneByUuid($dto->getUuid());
        
        if($shipmentAggregate->isNull()) throw new NotFoundException("shippiment");

        $shipmentAggregate->setStateToDelivered();

        $this->shippingRepository->saveChanges($shipmentAggregate);
        return new SuccessResponse([
            "message" => "Shipment successfully delivered to customer",
            "data" => [
                "uuid" => $shipmentAggregate->getUuid()
            ]
        ]);
    }

    function isShipmentDelivered($dto) {
        $shipmentAggregate = $this->shippingRepository->findOneByUuid($dto->getUuid());
        
        if($shipmentAggregate->isNull()) throw new NotFoundException("shippiment");

        $shipmentAggregate->isDelivered();
    }

    function setStateToCanceled(ShippingStatusDto $shippingStatusDto) {
        $shipmentAggregate = $this->shippingRepository->findOneByUuid($shippingStatusDto->getUuid());
        
        if($shipmentAggregate->isNull()) throw new NotFoundException("shippiment");

        $shipmentAggregate->setStatusToCanceled();
        
        $this->shippingRepository->saveChanges($shipmentAggregate);
    }
}