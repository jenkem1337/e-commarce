<?php
class ProductServiceImpl implements ProductService {
    private ProductRepository $productRepository;
    private EmailService $emailService;
    private ProductFactoryContext $productFactoryContext;
    private UploadService $uploadService;
	function __construct(
        ProductRepository $productRepository,
        UploadService $uploadService,
        EmailService $emailService,
        ProductFactoryContext $productFactoryContext,
    ) {
	    $this->productRepository     = $productRepository;
        $this->uploadService = $uploadService;
        $this->emailService = $emailService;
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
    function deleteProduct(DeleteProductByUuidDto $dto):ResponseViewModel 
    {
        $productDomainObject = $this->productRepository->findOneProductByUuid($dto->getUuid());
        if($productDomainObject->isNull()) throw new NotFoundException('product');
        
        if(count($productDomainObject->getImages()->getItems()) >= 1){
            foreach($productDomainObject->getImages()->getItems() as $image){
                $this->uploadService->deleteImageByUuid($image->getImageName(), $productDomainObject->getUuid());
            }
        }
        $this->productRepository->deleteProductByUuid($productDomainObject);
        return new ProductDeletedResponseDto('Product deleted successfully');
    }
    function deleteProductSubscriber(DeleteProductSubscriberDto $dto): ResponseViewModel
    {
        $productDomainObject = $this->productRepository->findOneProductByUuid($dto->getProductUuid());
        
        if($productDomainObject->isNull()) throw new NotFoundException('product');
        
        if(!( count($productDomainObject->getSubscribers()->getItems()) >=1) ){
            throw new DoesNotExistException('subscriber');
        }
        $flag = false;
        foreach($productDomainObject->getSubscribers()->getIterator() as $subscriber) {
            if($subscriber->getUserUuid() == $dto->getSubscriberUuid() && !($subscriber->isNull())){
                $flag = true;
            }
        }
        if($flag) $this->productRepository->deleteProductSubscriberByUserAndProductUuid($dto->getSubscriberUuid() ,$dto->getProductUuid());
        if(!$flag) throw new DoesNotExistException('Product subscriber');
        
        return new ProductSubscriberDeletedResponseDto('Product subscriber deleted successfully');

    }
    function findAllProduct(FindAllProductsDto $dto): ResponseViewModel
    {
        $products = $this->productRepository->findAllProducts();
        foreach($products->getIterator() as $productDomainObject) {
            if($productDomainObject->isNull()) {
                throw new NotFoundException('product');
            }
            $productDomainObject->calculateAvarageRate();
        }
        return new AllProductResponseDto($products);
    }
    function findAllProductWithPagination(FindAllProductWithPaginationDto $dto): ResponseViewModel
    {
        $products = $this->productRepository->findAllWithPagination($dto->getStartingLimit(), $dto->getPerPageForProduct());
        foreach($products->getIterator() as $productDomainObject) {
            if($productDomainObject->isNull()) {
                throw new NotFoundException('product');
            }
            $productDomainObject->calculateAvarageRate();
        }
        return new AllProductWithPaginationResponseDto($products);
    }   
    function updateProductBrandName(ChangeProductBrandNameDto $dto): ResponseViewModel
    {
        $productDomainObject = $this->productRepository->findOneProductByUuid($dto->getUuid());
        
        if($productDomainObject->isNull()) throw new NotFoundException('product');

        $productDomainObject->changeBrand($dto->getNewBrandName());
        $this->productRepository->updateProductBrandName($productDomainObject);
        
        return new ProductBrandNameChangedSuccessfullyResponseDto('Product brand name changed successfully');
    }
    function updateProductModelName(ChangeProductModelNameDto $dto): ResponseViewModel
    {
        $productDomainObject = $this->productRepository->findOneProductByUuid($dto->getUuid());
        if($productDomainObject->isNull()) throw new NotFoundException('product');
        $productDomainObject->changeModel($dto->getNewModelName());

        $this->productRepository->updateProductModelName($productDomainObject);
        
        return new ProductModelNameChangedResponseDto('Product model name changed successfully');
    }
    function updateProductHeader(ChangeProductHeaderDto $dto): ResponseViewModel
    {
        $productDomainObject = $this->productRepository->findOneProductByUuid($dto->getUuid());
        if($productDomainObject->isNull()) throw new NotFoundException('product');
        $productDomainObject->changeHeader($dto->getNewHeaderName());

        $this->productRepository->updateProductHeader($productDomainObject);
        
        return new ProductHeaderChangedResponseDto('Product header changed successfully');

    }
    function updateProductDescription(ChangeProductDescriptionDto $dto): ResponseViewModel
    {
        $productDomainObject = $this->productRepository->findOneProductByUuid($dto->getUuid());
        if($productDomainObject->isNull()) throw new NotFoundException('product');
        $productDomainObject->changeDescription($dto->getNewDescription());

        $this->productRepository->updateProductDescription($productDomainObject);
        
        return new ProductDescriptionChangedResponseDto('Product description changed successfully');

    }
    function updateProductPrice(ChangeProductPriceDto $dto): ResponseViewModel
    {
        $productDomainObject = $this->productRepository->findOneProductByUuid($dto->getUuid());
        if($productDomainObject->isNull()) throw new NotFoundException('product');
        $productDomainObject->changePrice($dto->getNewPrice());
        
        if($productDomainObject->isPriceLessThanPreviousPrice()) {
            foreach($productDomainObject->getSubscribers() as $subscribers) {
                $this->emailService->notifyProductSubscribersForPriceChanged($productDomainObject, $subscribers);
            }
        }
        $this->productRepository->updateProductPrice($productDomainObject);
        return new ProductPriceChangedResponseDto('Product price changed successfully');
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