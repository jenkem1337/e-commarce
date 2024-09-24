<?php

use PhpParser\JsonDecoder;
use Predis\Client;
class ProductServiceImpl implements ProductService {
    private ProductRepository $productRepository;
    private EmailService $emailService;
    private ProductFactoryContext $productFactoryContext;
    private ProductSubscriberFactory $productSubscriberFactory;
    private UploadService $uploadService;
    private Client $redisClient;
	function __construct(
        ProductRepository $productRepository,
        UploadService $uploadService,
        EmailService $emailService,
        ProductFactoryContext $productFactoryContext,
        Factory $productSubscriberFactory,
        Client $redisClient
    ) {
	    $this->productRepository     = $productRepository;
        $this->uploadService = $uploadService;
        $this->emailService = $emailService;
        $this->productFactoryContext = $productFactoryContext;
        $this->productSubscriberFactory = $productSubscriberFactory;
        $this->redisClient = $redisClient;
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
        
        $productForCategoryDomainModel = $this->productRepository->findASetOfProductCategoryByUuids($dto->getCategories());
        
        if(count($productForCategoryDomainModel->getCategories()->getItems()) == 0){
            throw new NotFoundException("Category(ies)");
        }

        foreach($productForCategoryDomainModel->getCategories() as $category){
            $category->setProductUuid($productDomainObject->getUuid());
            $productDomainObject->addCategory($category);            
        }

        $this->productRepository->createProduct($productDomainObject);
        
        return new SuccessResponse([
                "message" => "Product created successfully !",
                "data" => [
                    "uuid" => $dto->getUuid(),
                    "brand"=>$dto->getBrand(),
                    "model"=>$dto->getModel(),
                    "header"=>$dto->getHeader(),
                    "description"=>$dto->getDescription(),
                    "price"=>$dto->getPrice(),
                    "stock_quantity"=>$dto->getStockQuantity(),
                    "categories"=>$productDomainObject->getCategories()->getItems(),
                    "created_at"=>$dto->getCreatedAt(),
                    "updated_at"=>$dto->getUpdatedAt()
                ]
            ]);
    }
    function createNewProductSubscriber(ProductSubscriberCreationalDto $dto): ResponseViewModel
    {
        $productDomainObject = $this->productRepository->findOneProductWithOnlySubscriberByUuid($dto->getProductUuid(), $dto->getUserUuid());
        
        $productDomainObject->isNull() ?? throw new NotFoundException('product');
        
        $productDomainObject->subscribeToProduct($dto->getUserUuid());
        
        $this->productRepository->saveChanges($productDomainObject);
        
        return new SuccessResponse([
            "message" => 'Subscribed to product successfully',
            "data" => [
                "product_uuid" => $dto->getProductUuid(),
                "user_uuid" =>  $dto->getUserUuid(),
            ] 
        ]);
    }
    function deleteProduct(DeleteProductByUuidDto $dto):ResponseViewModel 
    {
        $productDomainObject = $this->productRepository->findOneProductByUuid($dto->getUuid(), [
            "comments"=>false,
            "subscribers"=>false,
            "categories"=>false,
            "rates"=> false,
            "images"=>"get"
        ]);
        if($productDomainObject->isNull()) throw new NotFoundException('product');
        
        if(count($productDomainObject->getImages()->getItems()) >= 1){
            foreach($productDomainObject->getImages()->getItems() as $image){
                $this->uploadService->deleteImageByUuid($image->getImageName(), $productDomainObject->getUuid());
            }
        }
        $this->productRepository->deleteProductByUuid($productDomainObject);
        return new SuccessResponse([
            "message" => 'Product deleted successfully',
            "data" => [
                "product_uuid" => $dto->getUuid(),
            ] 
        ]);
    }
    function deleteProductSubscriber(DeleteProductSubscriberDto $dto): ResponseViewModel
    {
        $productDomainObject = $this->productRepository->findOneProductWithOnlySubscriberByUuid($dto->getProductUuid(), $dto->getSubscriberUuid());
        
        if($productDomainObject->isNull()) throw new NotFoundException('product');
        
        $productDomainObject->unSubscribeToProduct($dto->getSubscriberUuid()); 

        $this->productRepository->saveChanges($productDomainObject);
        
        return new SuccessResponse([
            "message" => 'Subscriber deleted successfully',
            "data" => [
                "product_uuid" => $dto->getProductUuid(),
                "user_uuid" =>  $dto->getSubscriberUuid(),
            ] 
        ]);
    }
    function findProductsByCriteria(FindProductsByCriteriaDto $dto): ResponseViewModel
    {
        $products = $this->productRepository->findProductsByCriteria($dto);
        return new AllProductResponseDto($products);
    }
    function findProductsBySearch(FindProductsBySearchDto $dto): ResponseViewModel
    {
        $products = $this->productRepository->findProductsBySearch(
            $dto->getSearchValue(), $dto->getStartingLimit(), $dto->getPerPageForProduct(), $dto->getFilter()
        );
        return new SearchedProductResponseDto($products);
    }
   
    function findOneProductByUuid(FindOneProductByUuidDto $dto):ResponseViewModel{
        $productDomainObject = $this->productRepository->findOneProductByUuid($dto->getUuid(),$dto->getFilter());

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
            $productDomainObject->getUpdatedAt(),
        );
    }
    function updateProductDetailsByUuid(ProductDetailDto $dto): ResponseViewModel {
        $productDomainObject = $this->productRepository->findOneProductByUuid($dto->getUuid(),[
            "comments"=>false,
            "subscribers"=>false,
            "categories"=>false,
            "rates"=> false,
            "images"=>false
        ]);
        if($productDomainObject->isNull()) throw new NotFoundException('product');
        
        $productDomainObject->changeDetails(
            $dto->getModel(),
            $dto->getBrand(),
            $dto->getHeader(),
            $dto->getDescription(),
            $dto->getPrice()
        );
        $this->productRepository->saveChanges($productDomainObject);
        return new SuccessResponse([
            "message" => "Product details changed successfully",
            "data" => [
                "uuid" => $dto->getUuid(),
                "brand"=>$dto->getBrand(),
                "model"=>$dto->getModel(),
                "header"=>$dto->getHeader(),
                "description"=>$dto->getDescription(),
                "price"=>$dto->getPrice(),
            ]
        ]);
    }
    function updateProductStockQuantity(ChangeProductStockQuantityDto $dto): ResponseViewModel
    {
        $productDomainObject = $this->productRepository->findOneProductByUuid($dto->getProductUuid(), [
            "comments"=>false,
            "subscribers"=>false,
            "categories"=>false,
            "rates"=> false,
            "images"=>false
        ]);
        
        if($productDomainObject->isNull()) throw new NotFoundException('product');
        
        switch($dto->getUpdatingStrategy()){
            
            case StockQuantityChangingConstant::INCREMENT_QUANTITY:
                $productDomainObject->incrementStockQuantity($dto->getQuantity());
                break;
            
            case StockQuantityChangingConstant::DECREMENT_QUANTITY: 
                $productDomainObject->decrementStockQuantity($dto->getQuantity());
                break;
        }
        $this->productRepository->saveChanges($productDomainObject);

        return new SuccessResponse([
            "message" => "Product quantity changed successfully",
            "data" => [
                "uuid" => $dto->getProductUuid(),
                "stock_quantity" => $productDomainObject->getStockQuantity()
            ] 
        ]);
    }
}