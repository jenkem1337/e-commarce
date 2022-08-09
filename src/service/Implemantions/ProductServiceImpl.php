<?php
require './vendor/autoload.php';
class ProductServiceImpl implements ProductService {
    private ProductRepository $productRepository;
    private ProductFactoryContext $productFactoryContext;
	function __construct(
        ProductRepository $productRepository,
        ProductFactoryContext $productFactoryContext,
    ) {
	    $this->productRepository     = $productRepository;
        $this->productFactoryContext = $productFactoryContext;

	}
    function craeteNewProduct(ProductCreationalDto $dto): ResponseViewModel
    {
        $productDomainObject = $this->productFactoryContext->executeFactory(
            ProductFactory::class,
            true,
            $dto->getUuid(),
            $dto->getBrand(),
            $dto->getModel(),
            $dto->getHeader(),
            $dto->getDescription(),
            $dto->getPrice(),
            $dto->getStockQuantity(),
            $dto->getCreatedAt(),
            $dto->getUpdatedAt()
        );
        $categoriesResponseArray = [];
        foreach($dto->getCategories() as $categoryUuid) {
            $categoryDomainObject = $this->productRepository->findOneCategoryByUuid($categoryUuid)
                                                ->getCategories()
                                                ->getItem($categoryUuid);
            if($categoryDomainObject->isNull()){
                throw new NotFoundException('category');
            }
           
            $categoriesResponseArray[]= $categoryDomainObject->getCategoryName();
            
            $categoryDomainObject->setProductUuid($productDomainObject->getUuid());
            $productDomainObject->addCategory($categoryDomainObject);            
        }
        $this->productRepository->createProduct($productDomainObject);
        
        return new ProductCreatedResponseDto(
            $dto->getUuid(),
            $dto->getBrand(),
            $dto->getModel(),
            $dto->getHeader(),
            $dto->getDescription(),
            $dto->getPrice(),
            $dto->getStockQuantity(),
            $categoriesResponseArray,
            $dto->getCreatedAt(),
            $dto->getUpdatedAt()
        );
    }
    function updateProductBrandName(ChangeProductBrandNameDto $dto): ResponseViewModel
    {
        $productDomainObject = $this->productRepository->findOneProductByUuid($dto->getUuid());
        
        if($productDomainObject->isNull()) throw new NotFoundException('product');

        $productDomainObject->changeBrand($dto->getNewBrandName());
        $this->productRepository->updateProductBrandName($productDomainObject);
        
        return new ProductBrandNameChangedSuccessfullyResponseDto('Product brand name changed successfully');
    }
    function findOneProductByUuid(FindOneProductByUuidDto $dto):ResponseViewModel{
        $productDomainObject = $this->productRepository->findOneProductByUuid($dto->getUuid());
        
        if($productDomainObject->isNull()) throw new NotFoundException('product');
        
        $productDomainObject->calculateAvarageRate();
        return new OneProductFoundedResponseDto(
            $productDomainObject->getUuid(),
            $productDomainObject->getBrand(),
            $productDomainObject->getModel(),
            $productDomainObject->getHeader(),
            $productDomainObject->getDescription(),
            $productDomainObject->getPrice(),
            $productDomainObject->getAvarageRate(),
            $productDomainObject->getStockQuantity(),
            $productDomainObject->getCategories(),
            $productDomainObject->getComments(),
            $productDomainObject->getRates(),
            $productDomainObject->getImages(),
            $productDomainObject->getSubscribers(),
            $productDomainObject->getCreatedAt(),
            $productDomainObject->getUpdatedAt()
        );
    }
}