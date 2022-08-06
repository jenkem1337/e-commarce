<?php
require './vendor/autoload.php';
use Ramsey\Uuid\Uuid;
class ProductServiceImpl implements ProductService {
    private ProductRepository $productRepository;
    private UploadService $uploadService;
    private ProductFactoryContext $productFactoryContext;
    private CategoryFactory $categoryFactory;
    private ImageFactory $imageFactory;
	function __construct(
        ProductRepository $productRepository,
        ProductFactoryContext $productFactoryContext,
        Factory $categoryFactory,
        Factory $imageFactory,
        UploadService $uploadService
    ) {
	    $this->productRepository     = $productRepository;
        $this->productFactoryContext = $productFactoryContext;
        $this->categoryFactory       = $categoryFactory; 
        $this->imageFactory          = $imageFactory;
        $this->uploadService         = $uploadService; 

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
                throw new DoesNotExistException('category');
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
    function uploadImageForProduct(ImageCreationalDto $dto): ResponseViewModel
    {
        $productDomainObject = $this->productRepository->findOneProductByUuid($dto->getProductUuid());
        if($productDomainObject->isNull()) throw new DoesNotExistException('product');
        
        return new ImageCreatedResponseDto($dto->getImages());
    }
    function createNewCategory(CategoryCreationalDto $dto): ResponseViewModel
    {
        $productForCategoryDomainObject = $this->productFactoryContext->executeFactory(
            ProductCategoryCreationalModelFactory::class,
            true
        );
        $categoryDomainObject = $this->categoryFactory->createInstance(
            true,
            $dto->getUuid(),
            $dto->getCategoryName(),
            $dto->getCreatedAt(),
            $dto->getUpdatedAt()
        );
        $categories = $this->productRepository->findOneCategoryByName($dto->getCategoryName())
                                            ->getCategories();

        foreach($categories->getIterator() as $category){
            if($category->getCategoryName() == $dto->getCategoryName()){
                 if(!($category->isNull())){
                    throw new AlreadyExistException('category');
                }
            }
        }

        $productForCategoryDomainObject->addCategory($categoryDomainObject);
        
        $this->productRepository->createCategory($productForCategoryDomainObject, $categoryDomainObject->getUuid());
        return new CategoryCreatedResponseDto(
            $dto->getUuid(),
            $dto->getCategoryName(),
            $dto->getCreatedAt(),
            $dto->getUpdatedAt()
        );
    }
    function findOneCategoryByUuid(FindCategoryByUuidDto $dto): ResponseViewModel
    {
        $category = $this->productRepository->findOneCategoryByUuid($dto->getUuid())
                                            ->getCategories()
                                            ->getItem($dto->getUuid());
        if($category->isNull()){
            throw new DoesNotExistException('category');
        }
        return new OneCategoryFoundedResponseDto(
            $category->getUuid(),
            $category->getCategoryName(),
            $category->getCreatedAt(),
            $category->getUpdatedAt()
        );
    }
    function findAllCategory(FindAllCategoryDto $dto): ResponseViewModel
    {
        $productForCategoryDomainObject = $this->productRepository->findAllCategory();
        $categoryCollection = $productForCategoryDomainObject->getCategories();
        return new AllCategoryResponseDto($categoryCollection->getIterator());
    }
    function updateCategoryNameByUuid(UpdateCategoryNameByUuidDto $dto): ResponseViewModel
    {
        $productForCategoryDomainObject = $this->productRepository->findOneCategoryByUuid($dto->getUuid());
        $category = $productForCategoryDomainObject->getCategories()
                                                ->getItem($dto->getUuid());
        if($category->isNull()){
            throw new DoesNotExistException('category');
        }
        $category->changeCategoryName($dto->getNewCategoryName());

        $productForCategoryDomainObject->addCategory($category);

        $this->productRepository->updateCategoryNameByUuid($productForCategoryDomainObject ,$dto->getUuid());
        return new CategoryNameChangedResponseDto('Category name changed successfuly');
    }
    function deleteCategoryByUuid(DeleteCategoryDto $dto): ResponseViewModel
    {
        $category = $this->productRepository->findOneCategoryByUuid($dto->getUuid())
                                            ->getCategories()
                                            ->getItem($dto->getUuid());
        if($category->isNull()){
            throw new DoesNotExistException('category');
        }
        $this->productRepository->deleteCategoryByUuid($dto->getUuid());
        return new CategoryDeletedResponseDto('Category deleted successfuly');

    }
}