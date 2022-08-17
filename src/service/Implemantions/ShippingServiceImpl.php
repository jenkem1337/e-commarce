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
        foreach($shippings->getIterator() as $shipping) {
            if($shipping->isNull()) throw new NotFoundException('shipping');
        }
        return new AllShippingMethodsResponseDto($shippings);
    }
    function findOneByUuid(FindOneShippingMethodDto $dto): ResponseViewModel
    {
        $shippingDomainModel = $this->shippingRepository->findOneByUuid($dto->getUuid());
        if($shippingDomainModel->isNull()) throw new NotFoundException('shipping');
        return new OneShippingMethodFoundedResponseDto(
            $shippingDomainModel->getUuid(),
            $shippingDomainModel->getShippingType(),
            $shippingDomainModel->getPrice(),
            $shippingDomainModel->getCreatedAt(),
            $shippingDomainModel->getUpdatedAt()
        );
    }
}