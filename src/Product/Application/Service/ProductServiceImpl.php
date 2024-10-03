<?php

use PhpParser\JsonDecoder;
use Predis\Client;
class ProductServiceImpl implements ProductService {
    private ProductRepository $productRepository;
    private CategoryRepository $categoryRepository;
    private EmailService $emailService;
    private UploadService $uploadService;
	function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        UploadService $uploadService,
        EmailService $emailService,
    ) {
	    $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->uploadService = $uploadService;
        $this->emailService = $emailService;
    }
    function craeteNewProduct(ProductCreationalDto $dto): ResponseViewModel
    {
        $productDomainObject = Product::createNewProduct(
            $dto->getUuid(),
            $dto->getBrand(),
            $dto->getModel(),
            $dto->getHeader(),
            $dto->getDescription(),
            $dto->getPrice(),
            $dto->getStockQuantity(),
        );
        
        $categories = $this->categoryRepository->findASetOfByUuids($dto->getCategories());
        
        $productDomainObject->addCategories($categories);

        $this->productRepository->saveChanges($productDomainObject);
        
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
        $productDomainObject = $this->productRepository->findOneProductAggregateByUuid($dto->getUuid(), [
            "comments"=>false,
            "subscribers"=>false,
            "categories"=>false,
            "rates"=> false,
            "images"=>"get"
        ]);
        if($productDomainObject->isNull()) throw new NotFoundException('product');
        
        if(count($productDomainObject->getImages()->getItems()) >= 1){
            foreach($productDomainObject->getImages()->getItems() as $image){
                $this->uploadService->deleteOneImageByUuid($image->getLocation());
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
        return new SuccessResponse([
            "data" => $products
        ]);
    }
    function findProductsBySearch(FindProductsBySearchDto $dto): ResponseViewModel
    {
        $products = $this->productRepository->findProductsBySearch(
            $dto->getSearchValue(), $dto->getStartingLimit(), $dto->getPerPageForProduct(), $dto->getFilter()
        );
        return new SuccessResponse([
            "data" => $products
        ]);
    }
   
    function findOneProductByUuid(FindOneProductByUuidDto $dto):ResponseViewModel{
        $productObject = $this->productRepository->findOneProductByUuid($dto->getUuid(),$dto->getFilter());

        if($productObject->isNull) throw new NotFoundException('product');
        
        return new SuccessResponse([
            "data" => $productObject
        ]);
    }
    function updateProductDetailsByUuid(ProductDetailDto $dto): ResponseViewModel {
        $productDomainObject = $this->productRepository->findOneProductAggregateByUuid($dto->getUuid(),[
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
        $productDomainObject = $this->productRepository->findOneProductAggregateByUuid($dto->getProductUuid(), [
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